-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1:3306
-- Vytvořeno: Pon 18. bře 2024, 13:21
-- Verze serveru: 10.11.0-MariaDB
-- Verze PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `potraviny`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `town` varchar(45) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `postcode` varchar(60) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `street` varchar(100) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `country` varchar(45) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=186 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

--
-- Vypisuji data pro tabulku `address`
--

INSERT INTO `address` (`id`, `town`, `postcode`, `street`, `country`) VALUES
(170, 'Ustí nad Orlicí', '562 01', 'Horní Houžovec 20', 'czechia'),
(171, 'Kokot', '53501', 'Kokot 89', 'czechia'),
(172, 'pardzuce', '21222', 'pardubice', 'czechia'),
(173, 'Ústí nad Orlicí', '56201', 'Horní Houžovec 20', 'czechia'),
(174, 'Ústí nad Orlicí', '56201', 'Horní Houžovec 20', 'czechia'),
(175, 'Ustí nad Orlicí', '562 01', 'Horní Houžovec 20', 'czechia'),
(176, 'Ustí nad Orlicí', '562 01', 'Horní Houžovec 20', 'czechia'),
(177, 'Ustí nad Orlicí', '562 01', 'Horní Houžovec 20', 'czechia'),
(178, 'Ustí nad Orlicí', '562 01', 'Horní Houžovec 20', 'czechia'),
(179, 'Ustí nad Orlicí', '562 01', 'Horní Houžovec 20', 'czechia'),
(180, 'Ustí nad Orlicí', '562 01', 'Horní Houžovec 20', 'czechia'),
(181, 'Facilis anim id enim', '5555', 'Est voluptates quia', 'slovakia'),
(182, 'Eum assumenda deseru', '5555', 'Veritatis corrupti ', 'czechia'),
(183, 'Ustí nad Orlicí', '562 01', 'Horní Houžovec 20', 'czechia'),
(184, 'Ustí nad Orlicí', '562 01', 'Horní Houžovec 20', 'czechia'),
(185, 'Ustí nad Orlicí', '562 01', 'Horní Houžovec 20', 'czechia');

-- --------------------------------------------------------

--
-- Struktura tabulky `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  `slug` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`category`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

--
-- Vypisuji data pro tabulku `category`
--

INSERT INTO `category` (`id`, `category`, `disabled`, `slug`) VALUES
(1, 'Sladkosti ', 0, 'sladkosti'),
(2, 'Uzeniny', 0, 'uzeniny'),
(3, 'Zelenina', 0, 'zelenina'),
(4, 'Salámy', 0, 'salamy'),
(5, 'Ovoce', 0, 'ovoce'),
(9, 'Pečivo', 0, 'pecivo');

-- --------------------------------------------------------

--
-- Struktura tabulky `codes`
--

DROP TABLE IF EXISTS `codes`;
CREATE TABLE IF NOT EXISTS `codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8mb3_czech_ci NOT NULL,
  `code` varchar(5) COLLATE utf8mb3_czech_ci NOT NULL,
  `expire` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `email` (`email`),
  KEY `code` (`code`),
  KEY `expire` (`expire`),
  KEY `fk_codes_users1` (`users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

--
-- Vypisuji data pro tabulku `codes`
--

INSERT INTO `codes` (`id`, `email`, `code`, `expire`, `users_id`) VALUES
(1, 'kalejafi19@zaci.spse.cz', '37217', 1673955065, 1),
(5, 'kalejafi19@zaci.spse.cz', '34186', 1673955668, 1),
(6, 'parek@parek.com', '15235', 1673956500, 2),
(7, 'kalejafi19@zaci.spse.cz', '80068', 1673957126, 1),
(8, 'parek@parek.com', '75175', 1673957168, 2),
(9, 'kalejafi19@zaci.spse.cz', '10615', 1673957277, 1),
(10, 'parek@parek.com', '18950', 1673957403, 2),
(11, 'kalejafi19@zaci.spse.cz', '69177', 1674941687, 1),
(12, 'kalejafi19@zaci.spse.cz', '55418', 1674941767, 1),
(13, 'kalejafi19@zaci.spse.cz', '36225', 1674941873, 1),
(14, 'kalejafi19@zaci.spse.cz', '32514', 1675355000, 1),
(15, 'kalejafi19@zaci.spse.cz', '16745', 1676811167, 1),
(16, 'kalejafi19@zaci.spse.cz', '90444', 1678005044, 1),
(17, 'kalejafi19@zaci.spse.cz', '76798', 1678012797, 1),
(18, 'guguj.kaleja@gmail.com', '97765', 1678102778, 242),
(19, 'guguj.kaleja@gmail.com', '43943', 1678296108, 242),
(20, 'cibodo7134@oniecan.com', '47087', 1678966378, 248),
(21, 'gitegay939@necktai.com', '77873', 1679074057, 252),
(22, 'kalejafi19@zaci.spse.cz', '14263', 1679421836, 1),
(23, 'kalejafi19@zaci.spse.cz', '25403', 1679428013, 1),
(24, 'kalejafi19@zaci.spse.cz', '72801', 1679428242, 1),
(25, 'kalejafi19@zaci.spse.cz', '15935', 1679428338, 1),
(26, 'st72446@upce.cz', '77531', 1709414096, 1),
(27, 'st72446@upce.cz', '12579', 1709414441, 1),
(28, 'st72446@upce.cz', '78672', 1709415236, 1),
(29, 'st72446@upce.cz', '94790', 1709415391, 1),
(30, 'st72446@upce.cz', '14002', 1709415421, 1),
(31, 'st72446@upce.cz', '24171', 1709415522, 1),
(32, 'st72446@upce.cz', '75224', 1709415804, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(500) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_product_id` (`product_id`),
  KEY `fk_parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `comment`
--

INSERT INTO `comment` (`id`, `content`, `likes`, `date_created`, `product_id`, `user_id`, `parent_id`) VALUES
(60, 'Testovací komentář.', 0, '2024-03-18 10:31:28', 4, 1, NULL),
(62, 'Toto je odpověď na můj komentář.', 0, '2024-03-18 10:43:55', 4, 1, 60),
(64, 'Velice zajímavý komentář', 0, '2024-03-18 10:51:56', 4, 251, 60);

-- --------------------------------------------------------

--
-- Struktura tabulky `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  `lastname` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb3_czech_ci NOT NULL,
  `shipping_address` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `order_date` datetime NOT NULL,
  `paid` tinyint(1) NOT NULL,
  `payment_method` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(45) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `raw` text COLLATE utf8mb3_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_orders_users1_idx` (`users_id`),
  KEY `fk_orders_address1_idx` (`shipping_address`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

--
-- Vypisuji data pro tabulku `orders`
--

INSERT INTO `orders` (`id`, `firstname`, `lastname`, `email`, `shipping_address`, `users_id`, `order_date`, `paid`, `payment_method`, `amount`, `status`, `raw`) VALUES
(154, 'Filip', 'Kaleja', 'st72446@upce.cz', 183, 1, '2024-03-18 11:13:27', 0, 'card', '130.90', 'čekající', NULL),
(155, 'Filip', 'Kaleja', 'st72446@upce.cz', 184, 1, '2024-03-18 11:17:01', 0, 'card', '15.90', 'čekající', NULL),
(156, 'Filip', 'Kaleja', 'st72446@upce.cz', 185, 1, '2024-03-18 11:19:40', 0, 'card', '29.90', 'čekající', NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`,`order_id`,`product_id`),
  KEY `fk_table1_order1_idx` (`order_id`),
  KEY `fk_table1_product1_idx` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=293 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

--
-- Vypisuji data pro tabulku `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `total`, `amount`) VALUES
(290, 154, 4, 1, '130.90', '130.90'),
(291, 155, 1, 1, '15.90', '15.90'),
(292, 156, 11, 1, '29.90', '29.90');

-- --------------------------------------------------------

--
-- Struktura tabulky `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  `description` varchar(5000) COLLATE utf8mb3_czech_ci NOT NULL,
  `product_image` varchar(1024) COLLATE utf8mb3_czech_ci NOT NULL,
  `slug` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `views` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `fk_product_category1_idx` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

--
-- Vypisuji data pro tabulku `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `product_image`, `slug`, `category_id`, `date`, `price`, `views`) VALUES
(1, 'Okurka', 'Cena za jeden kus. ', 'uploads/images/products/1671478859okurka.jpg', 'okurka', 3, '2022-12-19', '15.90', 81),
(2, 'Slanina', 'Prodává se po 150g.', 'uploads/images/products/1671481355slanina.jpg', 'slanina', 2, '2022-12-19', '30.90', 346),
(4, 'Šunka', ' Nullam faucibus mi quis velit. Duis risus. Aliquam erat volutpat. Pellentesque ipsum. Sed convallis magna eu sem. Nullam sit amet magna in magna gravida vehicula. Aliquam erat volutpat. Etiam posuere lacus quis dolor. Donec iaculis gravida nulla.\r\n', 'uploads/images/products/1679423475ham-g802076c8c_1280.jpg', 'sunka', 4, '2022-12-23', '130.90', 557),
(11, 'Chleba', 'Vestibulum fermentum tortor id mi. Nunc tincidunt ante vitae massa. Nullam dapibus fermentum ipsum. Etiam ligula pede, sagittis quis, interdum ultricies, scelerisque eu. Aliquam ornare wisi eu metus. Sed convallis magna eu sem. Aliquam in lorem sit amet leo accumsan lacinia. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean fermentum risus id tortor. Vivamus ac leo pretium faucibus. Suspendisse nisl. Praesent dapibus.', 'uploads/images/products/1679071084bread-g4d40a8f54_1280.jpg', 'chleba', 9, '2023-03-17', '29.90', 0),
(12, 'Máslový croissant', 'Pellentesque sapien. Nulla turpis magna, cursus sit amet, suscipit a, interdum id, felis. Aliquam erat volutpat. Sed convallis magna eu sem. Maecenas sollicitudin. Donec quis nibh at felis congue commodo. Suspendisse nisl. Aliquam erat volutpat. Sed convallis magna eu sem. Fusce wisi. Cras pede libero, dapibus nec, pretium sit amet, tempor quis. Mauris elementum mauris vitae tortor. Sed ac dolor sit amet purus malesuada congue.', 'uploads/images/products/1679071197background-gf552046f1_1280.jpg', 'maslovy-croissant', 9, '2023-03-17', '19.90', 31),
(13, 'Skittles', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Fusce dui leo, imperdiet in, aliquam sit amet, feugiat eu, orci. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Nunc dapibus tortor vel mi dapibus sollicitudin. Vestibulum erat nulla, ullamcorper nec, rutrum non, nonummy ac, erat. Maecenas ipsum velit, consectetuer eu lobortis ut, dictum at dui. Maecenas sollicitudin.', 'uploads/images/products/1679422727skittles-g69c6cd975_1280.jpg', 'skittles', 1, '2023-03-21', '15.90', 2);

-- --------------------------------------------------------

--
-- Struktura tabulky `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

--
-- Vypisuji data pro tabulku `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'user'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Struktura tabulky `slider_images`
--

DROP TABLE IF EXISTS `slider_images`;
CREATE TABLE IF NOT EXISTS `slider_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(1024) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `title` varchar(100) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

--
-- Vypisuji data pro tabulku `slider_images`
--

INSERT INTO `slider_images` (`id`, `image`, `title`, `description`, `disabled`) VALUES
(1, 'uploads/images/slider/1674945179fruits.jpg', 'Nejlepší ovoce na trhu ', 'Dej si to XD ', 0),
(2, 'uploads/images/slider/1710768059PET7616f2_jidlozdrave.jpg', 'U nás je vše dobré ', 'ochutnej u nás vše :)', 0),
(3, 'uploads/images/slider/1672064138slanina.jpg', 'Slanina', 'U nás je nejlepší slanina.', 0),
(4, 'uploads/images/slider/1678355257asparagus-g7eb23d2e1_1920.jpg', 'Naše maso je nejlepší ', 'Odkud bereme potraviny?', 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8mb3_czech_ci NOT NULL,
  `firstname` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  `lastname` varchar(45) COLLATE utf8mb3_czech_ci NOT NULL,
  `password` varchar(225) COLLATE utf8mb3_czech_ci NOT NULL,
  `gender` varchar(45) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `date` date NOT NULL,
  `image` varchar(1024) COLLATE utf8mb3_czech_ci DEFAULT NULL,
  `banned` tinyint(1) NOT NULL,
  `role_id` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8mb3_czech_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_users_role1_idx` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=259 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `email`, `firstname`, `lastname`, `password`, `gender`, `date`, `image`, `banned`, `role_id`, `token`, `status`) VALUES
(1, 'st72446@upce.cz', 'Filip', 'Kaleja', '$2y$10$aYidJ3XOd0jMcMcIUxDeOeyZi6TjupkdEcSs2fcsL6cuyGyk/2VTe', 'male', '2022-11-26', 'uploads/images/1678353246entrepreneur-g8734bd692_1920.jpg', 0, 2, '', 1),
(251, 'email@email.com', 'Luboš', 'Pospíšil ', '$2y$10$Gn3ByWLMxbYoyqzyHokV9udY9biX7kQxeO51kpOWgIGcHHGkInuly', '', '2023-03-17', '', 0, 1, 'b0fbd3f819111a82be060571c35e2b332a6d7e9f34d370ed529965b36cbb', 1),
(255, 'ahoj@lol.cz', 'lol', 'lol', '$2y$10$SfwMcchoGbyagwLpjI/1vuCQdpsDrPmkOwH6xwzaJ.vwG4o9qqFKi', '', '2023-03-21', '', 0, 1, '0a8f749c1a995d38a236d37e885cced36dcf4e4d5dfd7767788d1a66cb77', 0),
(258, 'posova6983@fashlend.com', 'Newuser', 'Newuser', '$2y$10$cQXcrS8W5mCY3Pc2Wk1fmO2Q2LJDMMGfWpDJ2iEvUTs6kHqk6FgKK', '', '2024-03-03', '', 0, 1, 'b1394fe1d9bb4da91c0546aee20bdb281587afadcac7bfb8422adf69dbe4', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `user_address`
--

DROP TABLE IF EXISTS `user_address`;
CREATE TABLE IF NOT EXISTS `user_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`users_id`,`address_id`),
  KEY `fk_user_address_users1_idx` (`users_id`),
  KEY `fk_user_address_address1_idx` (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_czech_ci;

--
-- Vypisuji data pro tabulku `user_address`
--

INSERT INTO `user_address` (`id`, `users_id`, `address_id`) VALUES
(20, 1, 170);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `comment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Omezení pro tabulku `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `user_address`
--
ALTER TABLE `user_address`
  ADD CONSTRAINT `fk_user_address_address1` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
