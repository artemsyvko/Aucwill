<main>
    <div class="inner-main">
        <div class="content-block-lv2">
            <h1 class="hstyle-primary">管理者画面</h1>

            <div class="card">
                <div class="content-block-lv1">
                    <div class="wrap-tab">
                    <a class="tab" href="<?= base_url() ?>management-selling-schedule">本日発送予定分</a>
                    <a class="tab" href="<?= base_url() ?>management-enquiry">お問い合わせ</a>
                    <a class="tab active" href="<?= base_url() ?>management-schedule">納品予定連絡</a>
                    </div>
                </div>
                <div class="content-block-lv2">
                    <table class="schedule-tbl">
                        <tbody>
                        <?php foreach($schedules as $schedule) {  
                            if(!$schedule['schedule']['is_completed'] && !$schedule['schedule']['is_deleted']){?>
                                <tr id="block1-<?= $schedule['schedule']['id'] ?>" class="schedule-<?= $schedule['schedule']['id'] ?>">
                                    <td class="schedule-member-info" colspan="8">
                                        追跡番号: <?= $schedule['schedule']['tracking_number'] ?> &nbsp&nbsp
                                        管理番号: <?= $schedule['schedule']['management_number'] ?> &nbsp&nbsp
                                        会員: <?= $schedule['user']['name'] ?> 様 &nbsp&nbsp
                                        電話番号: <?= $schedule['member']['phone'] ?> &nbsp&nbsp
                                        到着予定日: <?= substr($schedule['schedule']['arrival_date'], 0, 10) ?>
                                        <button id="schedule_complete_button-<?= $schedule['schedule']['id'] ?>" class="btn">納品完了</button>
                                    </td>
                                </tr>
                                <tr id="block2-<?= $schedule['schedule']['id'] ?>" class="schedule-header">
                                    <td>商品名</td>
                                    <td>ナンバリング</td>
                                    <td>数量</td>
                                    <td>新品</td>
                                    <td>撮影</td>
                                    <td>採寸</td>
                                    <td>通電</td>
                                    <td></td>
                                </tr>
                                <?php foreach($schedule['products'] as $product) {?>
                                    <tr  class="block-<?= $schedule['schedule']['id'] ?>" id="prod-<?= $product['id'] ?>">
                                        <td id="prod_management_number-<?= $product['id'] ?>" style="display: none"><?= $product['prod_management_number'] ?></td>
                                        <td id="member_id-<?= $product['id'] ?>" style="display: none"><?= $product['member_id'] ?></td>
                                        <td id="prod_name-<?= $product['id'] ?>" class="text-center"><?= $product['prod_name'] ?></td>
                                        <td class="text-center"><?= $product['prod_serial'] ?></td>
                                        <td class="text-center"><?= $product['prod_quantity_in'] ?></td>
                                        <td class="text-center">
                                        <?php if($product['is_brand'] == 2) { ?>
                                                <input type="checkbox" id="is_brand-<?= $product['id'] ?>" class="checkbox-15" checked disabled>
                                            <?php } else if($product['is_brand'] == 1) { ?>
                                                <input type="checkbox" id="is_brand-<?= $product['id'] ?>" class="checkbox-15">
                                            <?php } else { ?>
                                                <input type="checkbox" id="is_brand-<?= $product['id'] ?>" class="checkbox-15" disabled>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if($product['req_photo'] == 2) { ?>
                                                <input type="checkbox" id="req_photo-<?= $product['id'] ?>" class="checkbox-15" checked disabled>
                                            <?php } else if($product['req_photo'] == 1) { ?>
                                                <input type="checkbox" id="req_photo-<?= $product['id'] ?>" class="checkbox-15">
                                            <?php } else { ?>
                                                <input type="checkbox" id="req_photo-<?= $product['id'] ?>" class="checkbox-15" disabled>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if($product['req_measure'] == 2) { ?>
                                                <input type="checkbox" id="req_measure-<?= $product['id'] ?>" class="checkbox-15" checked disabled>
                                            <?php } else if($product['req_measure'] == 1) { ?>
                                                <input type="checkbox" id="req_measure-<?= $product['id'] ?>" class="checkbox-15">
                                            <?php } else { ?>
                                                <input type="checkbox" id="req_measure-<?= $product['id'] ?>" class="checkbox-15" disabled>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if($product['req_call'] == 2) { ?>
                                                <input type="checkbox" id="req_call-<?= $product['id'] ?>" class="checkbox-15" checked disabled>
                                            <?php } else if($product['req_call'] == 1){ ?>
                                                <input type="checkbox" id="req_call-<?= $product['id'] ?>" class="checkbox-15">
                                            <?php } else { ?>
                                                <input type="checkbox" id="req_call-<?= $product['id'] ?>" class="checkbox-15" disabled>
                                            <?php } ?>
                                        </td>
                                        <td class="text-center">
                                            <a onclick="openProductInfoModal(<?= $product['id'] ?>)">情報追加</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr class="empty-row"><td colspan="8"></td></tr>
                        <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="out-div" style="display:none">
            <div class="info-modal">
                <span onclick="closeProductInfoModal()">X</span>
                <h3>商品写真撮影と採寸</h3>
                <h4>写真撮影</h4>
                <input id="product-id" hidden>
                <div id="upload-form">
                    <input type="file" id="file-input" multiple>
                    <button class="btn" type="submit" id="upload-btn">アップロード</button>
                </div>
                <div id="response1"></div>
                <h4>商品採寸</h4>
                <div id="measure-form">
                    <textarea id="measure-content"></textarea>
                    <button class="btn" id="measure-btn">採寸保存</button>
                </div>
                <div id="response2"></div>
            </div>
        </div>
    </div>
</main>

<script>
    function openProductInfoModal(id) {
        document.getElementById('product-id').value = id;
        document.getElementsByClassName('out-div')[0].style.display = "flex";
        document.getElementsByClassName('out-div')[0].style.zIndex = "999";
    }

    function closeProductInfoModal() {
        document.getElementsByClassName('out-div')[0].style.display = "none";
        document.getElementsByClassName('out-div')[0].style.zIndex = "-1";
        $('#response1').html('');
        $('#response2').html('');
    }
    
$(document).ready(function() {
    $('#upload-btn').click(function() {
        var formData = new FormData();
        formData.append('prod_id', $('#product-id').val());
        var files = $('#file-input')[0].files;

        for (var i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        $.ajax({
            url: '<?= base_url() ?>management/schedule/upload-photos',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#response1').html(response);
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });

    $('#measure-btn').click(function() {
        var prod_id = $('#product-id').val();
        var content = $('#measure-content').val();

        $.ajax({
            url: '<?= base_url() ?>management/schedule/save-measure',
            type: 'post',
            data: {
                prod_id: prod_id,
                content: content
            },
            success: function(response) {
                $('#response2').html(response);
                $('#measure-content').val('');
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
    })

    $('table tbody tr td.text-center input').click(function(event) {
        event.preventDefault();
        var checkbox = $(this);
        var column = checkbox.attr('id').split('-')[0];
        var id = checkbox.attr('id').split('-')[1];
        var management_number = $('#prod_management_number-'+id).text();
        var checked = checkbox.is(':checked');

        var prod_name = $('#prod_name-'+id).text();
        var confirmText = '';

        if(column == 'is_brand') confirmText = `商品「${prod_name}」が新品であることを確認しましたか？`;
        if(column == 'req_photo') confirmText = `商品「${prod_name}」の画像をアップロードしましたか？`;
        if(column == 'req_measure') confirmText = `商品「${prod_name}」の寸法を保存しましたか？`;
        if(column == 'req_call') confirmText = `商品「${prod_name}」の通電を確認しましたか？`;

        if(confirm(confirmText) == false) return;

        var member_id = $('#member_id-'+id).text();

        $.ajax({
            url: '<?= base_url() ?>management/schedule/check',
            type: 'post',
            data: {
                id: id,
                prod_management_number: management_number,
                member_id: member_id,
                column: column,
                checked: checked
            },
            success: function(response) {
                if(response == true) {
                    if (checked == true) {
                        checkbox.prop("checked", true);
                        checkbox.prop("disabled", true);
                    }
                    else {
                        checkbox.prop("checked", false);
                    }
                }
            }
        })
    })

    $('table tbody tr td.schedule-member-info button.btn').click(function() {
        var id = $(this).attr('id').split('-')[1];

        $.ajax({
            url: '<?= base_url() ?>management/schedule/complete',
            type: 'post',
            data: {
                id: id
            },
            success: function(response) {
                if(response == true) {
                    // alert("hide it")
                    $('#block1-' + id).hide();
                    $('#block2-' + id).hide();
                    $('.block-' + id).hide();
                }
            }
        })
    })
});


</script>