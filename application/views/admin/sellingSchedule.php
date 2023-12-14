<main>
    <div class="inner-main">
        <div class="content-block-lv2">
            <h1 class="hstyle-primary">管理者画面</h1>
            <div class="card">
                <div class="wrap-tab">
                    <a class="tab active" href="<?= base_url() ?>management-selling-schedule">本日発送予定分</a>
                    <a class="tab" href="<?= base_url() ?>management-enquiry">お問い合わせ</a>
                    <a class="tab" href="<?= base_url() ?>management-schedule">納品予定連絡</a>
                </div>
                <div class="enquiry-lines" style="display: inline-flex; margin-bottom: 5px">
                    <div style="padding: 5px 10px">
                        <span>全<?= count($selling_schedules) ?>件</span>
                    </div>
                    <div class="schedule-status-icons">
                        <span>新規受注: </span><img class="status" src="<?= base_url() ?>assets/images/new_order-40.png" alt="新規受注">
                        <span>配送中: </span><img class="status" src="<?= base_url() ?>assets/images/pending-40.png" alt="配送中">
                        <span>発送済み: </span><img class="status" src="<?= base_url() ?>assets/images/checked-40.png" alt="配達完了">
                        <a href="<?=base_url()?>management/download-schedules" target="_blank" class="custom-btn custom-ml-20">PDFダウンロード</a>
                    </div>
                </div>

                <div class="content-block-lv3">

                    <table class="enquiry-table">
                        <thead>
                            <tr>
                                <th class="s-schedule-th">受注番号</th>
                                <th class="s-schedule-th">会員住所</th>
                                <th class="s-schedule-th">受取人住所</th>
                                <th class="s-schedule-th">お荷物情報</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($selling_schedules as $schedule) {?>
                                <tr>
                                    <td class="custom-w-16p s-schedule-td text-center s-schedule-number">
                                        <span id="schedule_id-<?= $schedule['id'] ?>"><?= str_pad($schedule['id'], 5, '0', STR_PAD_LEFT) ?></span><br><br>

                                        <?php if($schedule['status'] == 0) { ?>
                                            <a class="custom-mb-25 delivery-status-flag" id="delivery-started-<?= $schedule['id'] ?>">配送受付</a>
                                        <?php } else if($schedule['status'] == 1) { ?>
                                            <a class="custom-mb-25 delivery-status-flag" id="delivery-finished-<?= $schedule['id'] ?>">配送完了</a>
                                        <?php } ?>

                                        <?php if($schedule['status'] == 0) { ?>
                                            <img class="status status-i" id="status-i-<?= $schedule['id'] ?>" src="<?= base_url() ?>assets/images/new_order-40.png" title="新規受注" alt="新規受注">
                                        <?php } else if($schedule['status'] == 1) { ?>
                                            <img class="status status-i" id="status-i-<?= $schedule['id'] ?>" src="<?= base_url() ?>assets/images/pending-40.png" title="配送中" alt="配送中">
                                        <?php } else if($schedule['status'] == 2) { ?>
                                            <img class="status status-i" id="status-i-<?= $schedule['id'] ?>" src="<?= base_url() ?>assets/images/checked-40.png" title="配達完了" alt="配達完了">
                                        <?php } ?>
                                    </td>
                                    <td class="custom-w-28p s-schedule-td">
                                        <span>会員番号: </span><span id="member_id-<?= $schedule['id'] ?>"><?= $schedule['member_id'] ?></span><br>
                                        <span>お名前: </span><?= $schedule['member_name'] ?><br>
                                        <span>発送元住所: </span><br>
                                        <?= '〒'.$schedule['member_post_code'].' '.
                                            $schedule['member_prefecture'].
                                            $schedule['member_address'].
                                            $schedule['member_building'] ?><br>
                                        <span>電話番号: </span><?= $schedule['member_phone'] ?><br>
                                    </td>
                                    <td class="custom-w-28p s-schedule-td">
                                        <div>
                                            <?php if($schedule['qrcode'] == '') { ?>
                                            <div>
                                                <span>お客様名: </span><?= $schedule['buyer_name'] ?><br>
                                                <span>発送先住所: </span><br>
                                                <?= '〒'.$schedule['buyer_post_code'].' '.
                                                    $schedule['buyer_prefecture'].
                                                    $schedule['buyer_address'].
                                                    $schedule['buyer_building'] ?><br>
                                                <span>電話番号: </span><?= $schedule['buyer_phone'] ?><br>
                                            </div>
                                            <?php } else { ?>
                                            <div class="text-center">
                                                <img class="qrcode" src="<?= base_url().'uploads/qrcode/'.$schedule['qrcode'] ?>" alt="qrcode">
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td class="custom-w-28p s-schedule-td">
                                        <span>商品管理番号: </span><span id="prod_management_number-<?= $schedule['id'] ?>"><?= $schedule['prod_management_number'] ?></span><br>
                                        <span>商品名: </span><?= $schedule['prod_name'] ?><br>
                                        <span>数量: </span><?= $schedule['prod_quantity_out'] ?><br>
                                        <?= $schedule['in_packet']?'可能な限りゆうパケットでの発送を希望する<br>':'' ?>
                                        <span>依頼日時: </span><?= $schedule['created_at'] ?><br>
                                        <span>配達希望日: </span><?= $schedule['arrival_date']=='0000-00-00'?'なし':$schedule['arrival_date'] ?><br>
                                        <span>配達希望時間: </span>
                                            <?= $schedule['arrival_time']=='00'?'なし':'' ?>
                                            <?= $schedule['arrival_time']=='51'?'午前中':'' ?>
                                            <?= $schedule['arrival_time']=='52'?'12~14時':'' ?>
                                            <?= $schedule['arrival_time']=='53'?'14~16時':'' ?>
                                            <?= $schedule['arrival_time']=='54'?'16~18時':'' ?>
                                            <?= $schedule['arrival_time']=='55'?'18~20時':'' ?>
                                            <?= $schedule['arrival_time']=='56'?'20~21時':'' ?>
                                            <br>
                                        <span>備考: </span><?= $schedule['note'] ?><br>

                                        <!-- <a class="prod-detail" id="image-prod_id-<?= $schedule['prod_id'] ?>">商品画像</a> -->
                                        <!-- <a class="prod-detail" id="measure-prod_id-<?= $schedule['prod_id'] ?>">商品寸法</a> -->
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- <div class="out-div" style="display:show">

            <div class="mySlides fade">
            <div class="numbertext">1 / 3</div>
            <img src="img_nature_wide.jpg" style="width:100%;z-index:1000" alt="noImg">
            <div class="text">Caption Text</div>
            </div>

            <div class="mySlides fade">
            <div class="numbertext">2 / 3</div>
            <img src="img_snow_wide.jpg" style="width:100%;z-index:1000" alt="noImg">
            <div class="text">Caption Two</div>
            </div>

            <div class="mySlides fade">
            <div class="numbertext">3 / 3</div>
            <img src="img_mountains_wide.jpg" style="width:100%;z-index:1000" alt="noImg">
            <div class="text">Caption Three</div>
            </div>

            <a class="prev" onclick="plusSlides(-1)">❮</a>
            <a class="next" onclick="plusSlides(1)">❯</a>

        </div> -->
    </div>

</main>

<script>

    $(document).on('click', '.delivery-status-flag', function () {
        var element = $(this);
        var schedule_id = element.attr('id').split('-')[2];
        var status = element.attr('id').split('-')[1];
        var str_schedule_id = $('#schedule_id-'+schedule_id).text();
        var member_id = $('#member_id-'+schedule_id).text();

        if(status == 'started') {
            if(confirm(`商品配送受注番号${str_schedule_id}の配送を開始しますか？`) == true) {
                $.post('<?= base_url() ?>stock/order-status', {
                    _method: 'POST',
                    schedule_id: schedule_id,
                    member_id: member_id,
                    prod_management_number: $('#prod_management_number-'+schedule_id).text(),
                    status: 1
                })
                .done(function(response){
                    if(response==1){
                        $('#status-i-'+schedule_id).attr('src', '<?= base_url() ?>assets/images/pending-40.png');
                        element.text('配達完了');
                        element.attr('id', 'status-finished-'+schedule_id);
                    }
                })
                .fail(function(xhr, textStatus, errorThrown) {
                    console.error("AJAX request failed:", textStatus, errorThrown);
                });
            }
        }

        if(status == 'finished') {
            if(confirm(`商品配送受注番号${str_schedule_id}の配送を開始しますか？`) == true) {
                $.post('<?= base_url() ?>stock/order-status', {
                    _method: 'POST',
                    schedule_id: schedule_id,
                    member_id: member_id,
                    prod_management_number: $('#prod_management_number-'+schedule_id).text(),
                    status: 2
                })
                .done(function(response){
                    if(response==1){
                        $('#status-i-'+schedule_id).attr('src', '<?= base_url() ?>assets/images/checked-40.png');
                        element.remove();
                    }
                })
                .fail(function(xhr, textStatus, errorThrown) {
                    console.error("AJAX request failed:", textStatus, errorThrown);
                });
            }
        }
    })

    // $(document).on('click', '.prod-detail', function () {
    //     var prod_id = $(this).attr('id').split('-')[2];
    //     var column_name = $(this).attr('id').split('-')[0];
        
    //     $.post('<?= base_url() ?>stock/order/product-detail', {
    //         _method: 'POST',
    //         prod_id: prod_id,
    //         column_name: column_name            
    //     })
    //     .done(function(response){
    //         if (column_name == 'image') {

    //         }

    //         if (column_name == 'measure') {
    //             $('#measure-prod_id-'+prod_id).after(response['html']);
    //             $('#measure-prod_id-'+prod_id).remove();
    //         }
    //     })
    //     .fail(function(xhr, textStatus, errorThrown) {
    //         console.error("AJAX request failed:", textStatus, errorThrown);
    //     });
    // })

</script>