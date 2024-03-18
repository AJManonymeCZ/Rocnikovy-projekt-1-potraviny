<?php

if (!defined("ROOT")) die("direct script access denied");

class ProductController extends Controller
{

    public function index($slug)
    {
        $data['title'] = "Produkt";

        $product = new Product();
        if ($row = $product->first(["slug" => $slug])) {
            //PRODUCT
            $views = (int)$row->views;
            $product->update($row->id, ["views" => $views += 1]);
            $data["product"] = $row;

            $query = "SELECT *, COUNT(order_details.product_id), product.slug AS 'product_slug' FROM product 
                JOIN order_details ON order_details.product_id = product.id 
                JOIN category ON category.id = product.category_id  
                GROUP BY 2 
                ORDER BY COUNT(order_details.product_id) DESC LIMIT 4;";
            $data["products"] = $product->query($query);

            //COMMENTS
            $commentModel = new Comment();
            $query = "select comment.*, users.firstname, users.lastname, users.image
                        from comment
                        join users on users.id = comment.user_id
                        where product_id = :product_id
                        order by date_created desc;";

            $comments = $commentModel->query($query, ['product_id' => $row->id]);
            if(!empty($comments)) {
                foreach ($comments as $key => $comment) {
                    if(!empty($comment->parent_id)) {
                        foreach ($comments as $key2 => $comment2) {
                            if($comment2->id == $comment->parent_id) {
                                $comment2->under_comment[] = $comment;
                                unset($comments[$key]);
                            }
                        }
                    }

                    $comment = $commentModel->calc_date($comment);

                    $comment->is_mine = Auth::getId() == $comment->user_id;

                }



                //var_dump($comments[6]->under_comment[0]->under_comment);
                $data['comments'] = $comments;
            }


        }

        $this->view("product", $data);
    }

    public function comment()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [];
            $data['errors'] = [];
            $data_type = $_POST['data_type'] ?? '';

            if(Auth::logged_in()) {
                if (!empty($data_type)) {
                    $productModel = new Product();
                    $commentModel = new Comment();
                    $userModel = new User();

                    if ($data_type == 'create') {

                        $product_id = $_POST['product_id'] ?? '';
                        if(!$productModel->first(["id" => $product_id])) {
                            return;
                        }

                        if($commentModel->validate($_POST)) {
                            $parent_id = $_POST['parent_id'] ?? '';

                            $arr = [];
                            $arr['content'] = $_POST['content'];
                            $arr['date_created'] = date("Y-m-d H:i:s");
                            $arr['product_id'] = $product_id;
                            $arr['user_id'] = Auth::getId();
                            $arr['parent_id'] = null;

                            if (!empty($parent_id)) {
                                if($commentModel->first(['id' => $parent_id])) {
                                    $arr['parent_id'] = $parent_id;
                                }
                            }

                            $curr_comment_id = $commentModel->insert($arr, true);

                            $query = "select comment.*, u.image, concat(u.firstname,concat(' ', u.lastname)) as fullname
                                        from comment
                                        join users u on comment.user_id = u.id
                                        where comment.id = :c and u.id = :u;";

                            $comment = $commentModel->query($query, ['c' => $curr_comment_id,'u' => Auth::getId()])[0];

                            if(empty($comment->image))
                                $comment->image = "assets/images/no_image.jpg";

                            $data['comment'] = $comment;
                            $data['data_type'] = 'show';
                        }
                    } else if($data_type == 'delete') {
                        $commentToDelete = $commentModel->first(['id' => $_POST['id'] ?? '']);

                        if(empty($commentToDelete) || $commentToDelete->user_id != Auth::getId())
                            return;

                        $commentModel->delete($commentToDelete->id);
                    } else if($data_type == 'edit') {
                        $commentToUpdate = $commentModel->first(['id' => $_POST['id'] ?? '']);

                        if(empty($commentToUpdate) || $commentToUpdate->user_id != Auth::getId())
                            return;

                        if($commentModel->validate($_POST)) {
                            $commentModel->update($commentToUpdate->id ,['content' => $_POST['content']]);
                        } else {
                            $data['errors'] = $commentModel->errors;
                        }

                    } else if($data_type == 'get') {
                        //get curr user
                        $query = "select concat(u.firstname,concat(' ', u.lastname)) as fullname, image from users u where id = :user_id";
                        $user = $userModel->query($query, ['user_id' => Auth::getId()])[0];

                        if(empty($user->image))
                            $user->image = "assets/images/no_image.jpg";

                        if(!$commentModel->first(['id' => $_POST['parent_id'] ?? '']) || !$productModel->first(['id' => $_POST['product_id']]))
                            return;

                        $user->p_id = $_POST['parent_id'];
                        $user->product_id = $_POST['product_id'];
                        $data['me'] = $user;
                        $data['data_type'] = 'user';
                    }
                }
            } else {
                //$data['errors'][] = "Pro psaní komentářů musíte být přihlšen/a.";
            }


            echo json_encode($data);
            die;
        }
    }
}
