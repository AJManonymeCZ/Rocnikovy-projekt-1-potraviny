<?php $this->view("admin/adminHeader"); ?>
<div id="translationsWrapper" class="table">
    <div class="languagesWrapper">
        <div class="heading">
            <h2><?= LanguageFactory::getLocalized("dashboard.languages") ?></h2>
            <a href="<?= getPath() ?>/admin/languages/add" class="btn"><i class='bx bx-plus'></i><?= LanguageFactory::getLocalized("dashboard.language") ?></a>
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
                        <?php foreach ($languages['fields'] as $field): ?>
                            <td><?= $language->$field ?></td>
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
        <div class="alert" style="display: none"></div>
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
                                    <td style="min-width: 167px" <?= $field !== "id" && $field !== "key" ? "data-language='" . $field . "'" : "" ?>  data-rowid="<?= $translation->id ?>"><?= $translation->$field ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                     <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

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
                                            const $alert = document.querySelector("#translationsWrapper .alert");
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
