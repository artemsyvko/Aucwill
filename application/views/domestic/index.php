<main>
  <div class="inner-main">
    <div class="content-block-lv2">
      <form class="wrap-headline-col2">
        <h1 class="hstyle-primary">国内発送一覧</h1>
        <div class="func" style="display: none;"><a class="textlink download" href="">CSVダウンロード</a>
          <div class="wrap-search">
            <input type="text" name="search" value="" placeholder="キーワード検索">
              <input type="hidden" name="sent" value="">
            <button class="btn navy">検索</button>
          </div>
        </div>
      </form>
      <div class="wrap-tab">
        <a href="<?= base_url() ?>domestic" class="tab active">未発送</a>
        <a href="<?= base_url() ?>domestic/sent" class="tab">発送済み</a>
      </div>
      
      <div class="content-block-lv3">

      <?php
      if(count($schedules) > 0) { ?>
        
      <div class="card">
        <?php foreach($schedules as $schedule) { ?>
          <table class="enquiry-table">
            <thead>
              <tr>
                <th class="s-schedule-th">発送受注番号: <?= str_pad($schedule['schedule']['id'], 5, '0', STR_PAD_LEFT) ?></th>
                <th class="s-schedule-th">商品管理番号</th>
                <th class="s-schedule-th">商品名</th>
                <th class="s-schedule-th">数量</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center"><img src="<?= base_url().$schedule['img_path'] ?>" alt="<?= $schedule['schedule']['prod_name'] ?>" style="width: 100px"></td>
                <td class="text-center"><?= $schedule['schedule']['prod_management_number'] ?></td>
                <td class="text-center"><?= $schedule['schedule']['prod_name'] ?></td>
                <td class="text-center"><?= $schedule['schedule']['prod_quantity_out'] ?></td>
              </tr>
            </tbody>
          </table>

          <table class="schedule-tbl">
            <tbody>
              <tr>
                <td style="width: 20%;">
                  <ul>
                    <li>
                      <b>依頼日時: </b><?= $schedule['schedule']['created_at'] ?>
                    </li>
                  </ul>
                </td>
                <td style="width: 30%;">
                  <div>
                    <b>発送先情報</b><br>
                    <?php if($schedule['schedule']['qrcode'] == '') { ?>
                      <span><?= $schedule['schedule']['buyer_name'] ?></span><br>
                      <span><?= "〒".$schedule['schedule']['buyer_post_code'].' '.$schedule['schedule']['buyer_prefecture'].$schedule['schedule']['buyer_address'].$schedule['schedule']['buyer_building'] ?></span><br>
                      <b>TEL. </b><span><?= $schedule['schedule']['buyer_phone'] ?></span><br>
                    <?php } else { ?>
                      <div style="width: 100%; text-align: center;"><img class="qrcode" style="width: 200px;" src="<?= base_url().'uploads/qrcode/'.$schedule['schedule']['qrcode'] ?>" alt="qrcode"></div>
                    <?php } ?>
                  </div>
                </td>
                <td style="width: 30%;">
                  <div>
                    <b>発送元情報</b><br>
                    <span><?= $schedule['schedule']['member_name'] ?></span><br>
                    <span><?= "〒".$schedule['schedule']['member_post_code'].' '.$schedule['schedule']['member_prefecture'].$schedule['schedule']['member_address'].$schedule['schedule']['member_building'] ?></span><br>
                    <b>TEL. </b><span><?= $schedule['schedule']['member_phone'] ?></span><br>
                  </div>
                </td>
                <td style="width: 20%;">
                  <div>
                    <b>料金</b>
                    <ul>
                      <li><b>国内手数料: </b>250</li>
                      <li><b>国内送料: </b>1100</li>
                    </ul>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        <?php } ?>
      </div>

      <?php
      } ?>

      </div>
    </div>
  </div>
</main>