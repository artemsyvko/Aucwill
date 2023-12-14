<main>
            
  <div class="inner-main">
    <div class="wrap-home-info">
      <div class="box">
        <h1 class="hstyle-basic">国内発送状況 (<?= date('Y年m月', time()) ?>)</h1>
        <div class="card home-info">
          <div class="icon"><img src="<?php echo base_url() ?>/assets/images/icon-done.svg" alt=""></div>
          <div class="right">
            <div class="count"><?= $completed_order_num ?><span>個</span></div>
            <div class="tx">発送済み</div>
          </div>
        </div>
      </div>
      <!-- <div class="box">
        <h1 class="hstyle-basic">海外発送件数 (2023年04月)</h1>
        <div class="card home-info">
          <div class="icon"><img src="<?php echo base_url() ?>/assets/images/icon-box.svg" alt=""></div>
          <div class="right">
            <div class="count">2<span>件</span></div>
            <div class="tx">発送済み</div>
          </div>
        </div>
      </div> -->
    </div>
    <div class="content-block-lv1">
      <div class="notice notice-info">
        <p>発送のカウントは<span class="bold">1</span>日から月末になります。</p>
      </div>
    </div>    
  </div>
</main>