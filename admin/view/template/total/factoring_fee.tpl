<?php echo $header; ?>
<div id="content">
    <div class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb): ?>
        <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
        <?php endforeach; ?>
    </div>
    <?php if ($error_warning): ?>
    <div class="warning"><?php echo $error_warning; ?></div>
    <?php endif; ?>
    <div class="box">
        <div class="heading">
            <h1><img src="view/image/total.png" alt="" /> <?php echo $heading_title; ?></h1>
            <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
        </div>
        <div class="content">
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
                <table class="form">
                    <tr>
                        <td><?php echo $entry_total ?></td>
                        <td><input type="text" name="factoring_fee[factoring_fee_total]" value="<?php echo $factoring_fee['factoring_fee_total']; ?>" /></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_fee ?></td>
                        <td><input type="text" name="factoring_fee[factoring_fee_fee]" value="<?php echo $factoring_fee['factoring_fee_fee']; ?>" /></td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_tax_class; ?></td>
                        <td><select name="factoring_fee[factoring_fee_tax_class_id]">
                                <option value="0"><?php echo $text_none; ?></option>
                                <?php foreach ($tax_classes as $tax_class): ?>
                                <?php if ($factoring_fee['factoring_fee_tax_class_id'] == $tax_class['tax_class_id']): ?>
                                <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>
                                <?php else: ?>
                                <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_status; ?></td>
                        <td><select name="factoring_fee[factoring_fee_status]">
                                <?php if ($factoring_fee['factoring_fee_status']): ?>
                                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                <option value="0"><?php echo $text_disabled; ?></option>
                                <?php else: ?>
                                <option value="1"><?php echo $text_enabled; ?></option>
                                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                <?php endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $entry_sort_order ?></td>
                        <td><input type="text" name="factoring_fee[factoring_fee_sort_order]" value="<?php echo $factoring_fee['factoring_fee_sort_order']; ?>" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php echo $footer; ?>