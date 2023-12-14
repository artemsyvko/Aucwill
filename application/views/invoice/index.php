<main>
  <main>
    <div class="inner-main">

      <?php
      if(empty($membership_transaction)){ ?>

      <div>
        <div class="content-block-lv2">
          <h1 class="hstyle-primary">入会金請求データ</h1>
          
          <div class="card">

            <ul class="" style="clear: both">
                <li>
                  <div class="status">
                    <a class="btn btn-download mb-10" href="<?php echo base_url()?>d-membership-invoice">PDF（入会金請求書）</a>
                  </div>
                </li>
            </ul>
            <div style="clear: both"></div>
          </div>
        </div>
      </div> 
      
      <?php
      } else { 
        $joinDateTime = new DateTime($membership_transaction[0]['created_at']);
        $formattedDate = $joinDateTime->format('Y年m月d日');
        ?>

      <div>
        <div class="content-block-lv2">
          <h1 class="hstyle-primary">入会金請求データ</h1>

          <div class="notice notice-info mb-20">
            <ul class="kome">
              <li><?= $this->session->userdata('name') ?> 様は<?= $formattedDate ?>に入会金を支払いました。</li>
            </ul>
          </div>

          <div class="card">
            <ul class="" style="clear: both">
                <li>
                  <div class="status">
                    <div class="label gray mb-10">お支払い済み</div>
                    <a class="btn btn-download mb-10" href="<?php echo base_url()?>d-membership-invoice">PDF（入会金請求書）</a>
                  </div>
                </li>
            </ul>
            <div style="clear: both"></div>
          </div>
        </div>
      </div>
      
      <?php
      } ?>

      <div>
        <div class="content-block-lv2">
          <h1 class="hstyle-primary">請求データ</h1>
          <div class="notice notice-info mb-20">
            <ul class="kome">
              <li>請求データは最近2年間のデータのみダウンロード可能です。</li>
            </ul>
          </div>
          <div class="card">

            <ul class="invoice-list" style="clear: both">
              <?php
              foreach ($transaction_button_data as $transaction) { ?>
                <li>
                  <div class="month"><?= $transaction['month'] ?>月</div>
                  <div class="status">
                    <?php if($transaction['is_paid'] == 1) { ?>
                    <div class="label gray mb-10">お支払い済み</div>
                    <?php } ?>
                    <a class="btn btn-download mb-10" href="<?php echo base_url()?>d-invoice/?month=<?= $transaction['year'].'-'.$transaction['month'] ?>" title="<?= $transaction['year'] ?>年">PDF（請求書）</a>
                    <a class="btn btn-download" href="<?php echo base_url()?>d-invoice-csv/?month=<?= $transaction['year'].'-'.$transaction['month'] ?>" title="<?= $transaction['year'] ?>年">CSV（明細）</a>
                  </div>
                </li> <?php
              } ?>
            </ul>
            <div style="clear: both"></div>
          </div>
        </div>
      </div>

      <div>
        <div class="content-block-lv2">
          <?php
          $currentDate = new DateTime(date('Y-m-d', time()));
          $currentDate->modify('last day of this month');
          $lastDate = $currentDate->format('Y-m-d');
          ?>
          <h1 class="hstyle-primary">ご利用状況<span class="small">(<?= $lastDate ?>締めの請求予定金額です)</span></h1>
          <div class="notice notice-info mb-20">
            <ul class="kome">
              <li>振込手数料は「会員様ご負担」でお願いします。</li>
              <li>お振込みはオークウィルに登録しているお名前での振り込みでお願いします。</li>
            </ul>
          </div>
          <div class="card">
            <dl class="invoince-this-month">
              <dt>今月のご利用金額目安</dt>
              <dd><?= $current_month_fee + MONTHLY_FEE ?><span class="yen">円</span></dd>
            </dl>
            <h2 class="title-table">ご利用明細</h2>
            <table class="enquiry-table">
              <thead>
                  <tr>
                      <th class="s-schedule-th">ご利用日</th>
                      <th class="s-schedule-th">商品管理番号</th>
                      <th class="s-schedule-th">発送受注番号</th>
                      <th class="s-schedule-th" colspan="2">料 金</th>
                  </tr>
              </thead>
              <tbody>
                <?php foreach ($current_month_billings as $current_month_billing) {
                  ?>
                    <tr>
                      <td class="text-center"><span class="custom-padding-20"><?= $current_month_billing['created_at'] ?></span></td>
                      <td class="text-center"><span class="custom-padding-20"><?= $current_month_billing['prod_management_number'] ?></span></td>
                      <td class="text-center"><span class="custom-padding-20"><?= $current_month_billing['prod_management_number'] == $current_month_billing['reference_id'] ? '' : str_pad($current_month_billing['reference_id'], 5, '0', STR_PAD_LEFT) ?></span></td>
                      <td class="text-right">
                        <span class="custom-padding-20">
                          <b><?= $current_month_billing['fee_type'] ?>: </b><?= $current_month_billing['fee_amount'] ?>円
                        </span>
                      </td>
                    </tr>
                  <?php
                } ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="content-block-lv2">
          <?php
            $lastMonthLastDay = new DateTime('last day of last month');
          ?>
          <h1 class="hstyle-primary">ご利用状況<span class="small">(<?= $lastMonthLastDay->format('Y-m-d') ?>締めの請求予定金額です)</span></h1>
          <div class="notice notice-info mb-20">
            <ul class="kome">
              <li>振込手数料は「会員様ご負担」でお願いします。</li>
              <li>お振込みはオークウィルに登録しているお名前での振り込みでお願いします。</li>
            </ul>
          </div>
          <div class="card">
            <dl class="invoince-this-month">
              <dt>今月のご利用金額目安</dt>
              <dd><?= $last_month_fee ?><span class="yen">円</span></dd>
            </dl>
            <h2 class="title-table">ご利用明細</h2>
            <table class="enquiry-table">
              <thead>
                  <tr>
                      <th class="s-schedule-th">ご利用日</th>
                      <th class="s-schedule-th">商品管理番号</th>
                      <th class="s-schedule-th">発送受注番号</th>
                      <th class="s-schedule-th" colspan="2">料 金</th>
                  </tr>
              </thead>
              <tbody>
                <?php foreach ($last_month_billings as $last_month_billing) {
                  ?>
                    <tr>
                      <td class="text-center"><span class="custom-padding-20"><?= $last_month_billing['created_at'] ?></span></td>
                      <td class="text-center"><span class="custom-padding-20"><?= $last_month_billing['prod_management_number'] ?></span></td>
                      <td class="text-center"><span class="custom-padding-20"><?= $last_month_billing['prod_management_number'] == $last_month_billing['reference_id'] ? '' : str_pad($last_month_billing['reference_id'], 5, '0', STR_PAD_LEFT) ?></span></td>
                      <td class="text-right">
                        <span class="custom-padding-20">
                          <b><?= $last_month_billing['fee_type'] ?>: </b><?= $last_month_billing['fee_amount'] ?>円
                        </span>
                      </td>
                    </tr>
                  <?php
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </main>
  <style>
    .red-border {
      color: red;
      border: solid 1px red;

    }
  </style>
</main>