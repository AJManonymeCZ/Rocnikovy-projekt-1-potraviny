<?php $this->view("admin/adminHeader"); ?>
<?php if($action == "addLanguage"): ?>
    <section class="main-content">
        <div class="wrapper">
            <div class="section">
                <h1><?= LanguageFactory::getLocalized("dashboard.translations.add.title") ?></h1>
                <form method="POST">
                    <div class="input-holder">
                        <label for="key"><?= LanguageFactory::getLocalized("dashboard.translations.add.key") ?></label>
                        <input type="text" name="key" id="key">
                        <small class="text-danger"><?= $errors['key'] ?? "" ?></small>
                    </div>
                    <div class="input-holder">
                        <label for="countryCode"><?= LanguageFactory::getLocalized("dashboard.translations.add.countryCode") ?></label>
                        <input type="text" name="countryCode" id="countryCode">
                        <small class="text-danger"><?= $errors['countryCode'] ?? "" ?></small>
                    </div>
                    <div class="input-holder">
                        <label for="country"><?= LanguageFactory::getLocalized("dashboard.translations.add.country") ?></label>
                        <input type="text" name="country" id="country">
                        <small class="text-danger"><?= $errors['country'] ?? "" ?></small>
                    </div>
                    <div class="btn-holder">
                        <button type="submit" class="btn-primary"><?= LanguageFactory::getLocalized("dashboard.save") ?></button>
                        <a href="<?= getPath() . "/admin/translations" ?>">
                            <button type="button" class="btn-secondary"><?= LanguageFactory::getLocalized("dashboard.cancel") ?></button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </section>
<?php elseif ($action == "editLanguage"): ?>
    <section class="main-content">
        <?php if (isset($row)): ?>
                <div class="wrapper">
                    <div class="section">
                            <h1><?= LanguageFactory::getLocalized("dashboard.translations.edit.title") ?></h1>
                            <form method="POST">
                                <div class="input-holder">
                                    <label for="key"><?= LanguageFactory::getLocalized("dashboard.translations.add.key") ?></label>
                                    <input type="text" name="key" id="key" value="<?= $row->key ?>">
                                    <small class="text-danger"><?= $errors['key'] ?? "" ?></small>
                                </div>
                                <div class="input-holder">
                                    <label for="countryCode"><?= LanguageFactory::getLocalized("dashboard.translations.add.countryCode") ?></label>
                                    <input type="text" name="countryCode" id="countryCode" value="<?= $row->countryCode ?>">
                                    <small class="text-danger"><?= $errors['countryCode'] ?? "" ?></small>
                                </div>
                                <div class="input-holder">
                                    <label for="country"><?= LanguageFactory::getLocalized("dashboard.translations.add.country") ?></label>
                                    <input type="text" name="country" id="country" value="<?= $row->country ?>">
                                    <small class="text-danger"><?= $errors['country'] ?? "" ?></small>
                                </div>
                                <div class="btn-holder">
                                    <button type="submit" class="btn-primary"><?= LanguageFactory::getLocalized("dashboard.edit") ?></button>
                                    <a href="<?= getPath() . "/admin/translations" ?>">
                                        <button type="button" class="btn-secondary"><?= LanguageFactory::getLocalized("dashboard.cancel") ?></button>
                                    </a>
                                </div>
                            </form>

                    </div>
                </div>
        <?php else: ?>
            <p><?= LanguageFactory::getLocalized("dashboard.noResults") ?></p>
        <?php endif; ?>
    </section>
<?php elseif ($action == "deleteLanguage"): ?>
    <section class="main-content">
        <?php if (isset($row)): ?>
            <div class="wrapper">
                <div class="section">
                    <h1><?= LanguageFactory::getLocalized("dashboard.translations.delete.title") ?></h1>
                    <div class="alert-danger"><?= LanguageFactory::getLocalized("dashboard.translations.delete.message") ?></div>
                    <form method="POST">
                        <div class="input-holder">
                            <label for="key"><?= LanguageFactory::getLocalized("dashboard.translations.add.key") ?></label>
                            <input disabled type="text" name="key" id="key" value="<?= $row->key ?>">
                            <small class="text-danger"><?= $errors['key'] ?? "" ?></small>
                        </div>
                        <div class="input-holder">
                            <label for="countryCode"><?= LanguageFactory::getLocalized("dashboard.translations.add.countryCode") ?></label>
                            <input disabled type="text" name="countryCode" id="countryCode" value="<?= $row->countryCode ?>">
                            <small class="text-danger"><?= $errors['countryCode'] ?? "" ?></small>
                        </div>
                        <div class="input-holder">
                            <label for="country"><?= LanguageFactory::getLocalized("dashboard.translations.add.country") ?></label>
                            <input disabled type="text" name="country" id="country" value="<?= $row->country ?>">
                            <small class="text-danger"><?= $errors['country'] ?? "" ?></small>
                        </div>
                        <div class="btn-holder">
                            <button type="submit" class="btn-danger"><?= LanguageFactory::getLocalized("dashboard.delete") ?></button>
                            <a href="<?= getPath() . "/admin/translations" ?>">
                                <button type="button" class="btn-secondary"><?= LanguageFactory::getLocalized("dashboard.cancel") ?></button>
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        <?php else: ?>
            <p><?= LanguageFactory::getLocalized("dashboard.noResults") ?></p>
        <?php endif; ?>
    </section>
<?php else: ?>
    <div id="translationsWrapper" class="table">
        <div class="languagesWrapper">
            <?php if(alert()): ?>
                <div id="translationLanguageAlert" class="<?= alert()['class'] ?>" onload="setTimeout(() => { this.style.display = 'none' }, 2000)"><?= alert("", true)['message'] ?></div>
                <script>
                    window.addEventListener("DOMContentLoaded", () => {
                        setTimeout(() => {
                            document.getElementById("translationLanguageAlert").style.display = 'none';
                        }, 2000);
                    });
                </script>
            <?php endif; ?>
            <div class="heading">
                <h2><?= LanguageFactory::getLocalized("dashboard.languages") ?></h2>
                <a href="<?= getPath() ?>/admin/translations/addLanguage" class="btn"><i class='bx bx-plus'></i><?= LanguageFactory::getLocalized("dashboard.language") ?></a>
            </div>
            <table id="languages">
                <?php if (!empty($languages)): ?>
                    <thead>
                        <?php foreach ($languages['fields'] as $field): ?>
                            <td><?= $field ?></td>
                        <?php endforeach; ?>
                    </thead>
                    <tbody>
                    <?php foreach ($languages['data'] as $language) : ?>
                        <tr>
                            <?php
                                $lastKey = array_key_last($languages['fields']);
                            ?>
                            <?php foreach ($languages['fields'] as $key => $field): ?>
                                <?php if ($lastKey == $key): ?>
                                    <td>
                                        <div class="table-icon">
                                            <a href="<?= getPath() . "/admin/translations/editLanguage/" . $language->id ?>"><i class="bx bx-edit-alt"></i></a>
                                            <a href="<?= getPath() . "/admin/translations/deleteLanguage/" . $language->id ?>"><i class="bx bxs-trash"></i></a>
                                        </div>
                                    </td>
                                <?php else: ?>
                                    <td><?= $language->$field ?></td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                <?php else: ?>
                    <p><?= LanguageFactory::getLocalized("dashboard.languages.noLanguagesFound") ?></p>
                <?php endif; ?>
            </table>
        </div>
        <div>
            <div id="translationAlert" class="alert" style="display: none"></div>
            <div class="heading">
                <h2><?= LanguageFactory::getLocalized("page.title.translations") ?></h2>
            </div>
            <?php if (!empty($fields)): ?>
                <table id="translations">
                    <thead>
                        <?php foreach ($fields as $field) : ?>
                            <td><?= $field ?></td>
                        <?php endforeach; ?>
                    </thead>
                    <tbody>
                         <?php if (!empty($translations)): ?>
                            <?php foreach ($translations as $translation) : ?>
                                <tr>
                                    <?php foreach ($fields as $field): ?>
                                        <td style=" overflow: hidden; white-space: normal;; min-width: 167px;<?= $field !== "id" && $field !== "key" ? "max-width:167px" : ""?>" <?= $field !== "id" && $field !== "key" ? "data-language='" . $field . "'" : "" ?>  data-rowid="<?= $translation->id ?>"><?= $translation->$field ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                         <?php endif; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        (() => {
            const rows = document.querySelectorAll("#translations tbody tr");

            let hasInput = false; // Move outside function

            const /**@returns HTMLInputElement*/ createInput = (/**string|null*/ value) => {
                const $input = document.createElement("input");
                $input.type = "text";
                $input.value = value || "";
                return $input;
            };

            const handleClickTD = ($td) => {
                if (hasInput) return; // Prevent multiple inputs
                const dataLanguageKey = $td.dataset.language;
                const originalValue = $td.innerHTML;

                if (typeof dataLanguageKey !== 'undefined') {
                    const $input = createInput(originalValue);
                    $td.innerHTML = "";
                    $td.append($input);
                    console.log($input.getBoundingClientRect());
                    $input.focus();
                    hasInput = true;

                    $input.addEventListener("focusout", () => {
                        let text = originalValue;
                        if ($input.value.trim().length > 0) {
                            text = $input.value;
                            // send the request
                            axios.post('<?= getPath() ?>/admin/translationApi', {
                                rowId: $td.dataset.rowid,
                                languageKey: dataLanguageKey,
                                translation: $input.value
                            })
                                .then((response) => {
                                    if (response.status === 200) {
                                        const message = response.data.message;
                                        if (message) {
                                            const $alert = document.querySelector("#translationsWrapper #translationAlert");
                                            $alert.innerHTML = message;
                                            $alert.style.display = "block";
                                            setTimeout(() => {
                                                $alert.style.display = "none";
                                                $alert.innerHTML = "";
                                            }, 3000);
                                        }
                                    }
                                })
                                .catch(error => console.log("ERROR: ", error));
                        }
                        $td.innerText = text;
                        $input.remove();
                        hasInput = false;
                    });
                }
            };

            rows.forEach(row => {
                row.addEventListener("click", (event) => {
                    let $td = event.target.closest("td"); // Ensures we get the <td>, even if a child element was clicked
                    if ($td) {
                        handleClickTD($td);
                    }
                });
            });

        })();
    });

</script>
<?php $this->view("admin/adminFooter"); ?>
