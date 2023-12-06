<div id="<?php echo $modalId; ?>"
    class="hidden fixed inset-0 bg-gray-700 bg-opacity-75 flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow">
        <button type="button" class="absolute top-4 right-4" onclick="toggleModal('<?php echo $modalId; ?>')"
            aria-hidden="true">&times;</button>
        <h4 class="text-lg font-bold mb-4">
            <?php echo $modalTitle; ?>
        </h4>
        <?php if(!empty($formFields)): ?>
            <div>
                <form method="POST" action="<?php echo $formAction; ?>">
                    <?php foreach($formFields as $field): ?>
                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2">
                                <?php echo $field['label']; ?>:
                            </label>
                            <?php
                            $fieldValue = isset($field['value']) ? $field['value'] : '';
                            if($field['type'] == 'textarea') {
                                echo '<textarea class="w-full p-2 border" name="'.$field['name'].'">'.$fieldValue.'</textarea>';
                            } else {
                                echo '<input class="w-full p-2 border" type="'.$field['type'].'" name="'.$field['name'].'" value="'.$fieldValue.'">';
                            }
                            ?>
                        </div>
                    <?php endforeach; ?>
                    <div>
                        <button type="button" class="bg-gray-500 text-white py-2 px-4 rounded mr-2"
                            onclick="toggleModal('<?php echo $modalId; ?>')">Cancel</button>
                        <button type="submit" name="<?php echo $submitBtnName; ?>"
                            class="bg-blue-500 text-white py-2 px-4 rounded">
                            <?php echo $submitBtnText; ?>
                        </button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>