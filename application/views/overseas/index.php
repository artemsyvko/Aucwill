<main>
  <div class="inner-main">
    <div class="content-block-lv2">
      <form class="wrap-headline-col2">
        <h1 class="hstyle-primary">海外発送一覧</h1>
        <div class="func"><a class="textlink download" href="<?php echo base_url()?>overseas/export?sent=<?php echo $sent ?>">CSVダウンロード</a>
          <div class="wrap-search">
            <input type="text" name="search" value="" placeholder="キーワード検索">
            <input type="hidden" name="sent" value="<?php echo $sent ?>">
            <button class="btn navy">検索 </button>
          </div>
        </div>
      </form>
      <div class="wrap-tab">
        <a class="tab <?php if ($sent == 0) {?>active<?php } ?>" href="<?php echo base_url()?>overseas">未発送</a>
        <a class="tab tab <?php if ($sent == 1) {?>active<?php } ?>" href="<?php echo base_url()?>overseas?sent=1">発送済み</a>
      </div>
      <?php if ($sent == 0) {?>
        <div class="pull-right"></div>
      <?php } ?>
      <?php if ($sent == 1) {?>
        <div class="card-type2">
          <div class="card-type2-head l-blue">
            <div class="title">
              <div class="label blue">発送済み</div>
              <h2>受注番号 IS-165250</h2>
            </div>
            <div class="area-button">
              <a class="contactForm btn" href="#inline-contactForm" data-modaal-scope="modaal_168192180666740df2a4c6fae7" data-prefix="海外発送/受注番号 IS-165250に関する問い合わせ 発送済み">&gt;&gt; この受注に関するお問い合わせ</a>
            </div>
          </div>
          <div class="card-type2-inner">
            <h3 class="title-table">発送内容</h3>
            <ul class="table-list order mb-20 scroll-shadow">
              <li class="list table-header">
                <div class="table-row bottom-line">
                  <div class="table-col photo"> </div>
                  <div class="table-col m-num">管理番号</div>
                  <div class="table-col name">商品名</div>
                  <div class="table-col quantity tx-right">数量</div>
                  <div class="table-col price tx-right">価格</div>
                  <div class="table-col edit"> </div>
                </div>
              </li>
              <li class="list">
                <div class="table-row bottom-line">
                  <div class="table-col photo"><img src="<?php echo base_url()?>assets/images/noImage.jpg" style="width:60px;"></div>
                  <div class="table-col m-num">
                    <div>1069592</div>
                  </div>
                  <div class="table-col name">
                    <div>ポケットピカチュウプリンタ</div>
                  </div>
                  <div class="table-col quantity tx-right">
                    <div>1</div>
                  </div>
                  <div class="table-col price tx-right">
                    <div>10000</div>
                  </div>
                </div>
              </li>
            </ul>
            <div class="wrap-orderInfo">
              <div class="orderInfo-left">
                <dl class="type-1">
                  <dt>依頼日時</dt>
                  <dd>2023-04-16 22:47:41</dd>
                </dl>
                <dl class="type-1">
                  <dt>発送方法</dt>
                  <dd>FedEx</dd>
                </dl>
                <dl class="type-1">
                  <dt>発送日時</dt>
                  <dd>2023-04-17</dd>
                </dl>
                <dl class="type-1">
                  <dt>追跡番号</dt>
                  <dd>397086763776</dd>
                </dl>
                <dl class="type-1">
                  <dt>eBay ID</dt>
                  <dd>22-09944-01538</dd>
                </dl>
                <dl class="type-1">
                  <dt>実重量</dt>
                  <dd>630</dd>
                </dl>
                <dl class="type-1">
                  <dt>容積重量</dt>
                  <dd>2000</dd>
                </dl>
              </div>
              <div class="orderInfo-middle">
                <dl class="type-2">
                  <dt>発送先情報</dt>
                  <dd>90061-2320 US CA Los Angeles 12117 S Main St 12117 S Main St<br> Ricardo Ochoa<br>5625648596</dd>
                </dl>
                <dl class="type-2">
                  <dt>発送元情報</dt>
                  <dd>1760021 Tokyo NERIMA KU NUKUI 3-28-5 SUNRISE FUJIMI 401<br>TAKAHIRO BANDO<br>08063580709</dd>
                </dl>
                <dl class="type-2">
                    <dt>料金</dt>
                    <dd>
                      海外発送手数料:250<br>
                      海外送料:3640<br>
                    </dd>
                  </dl>
                </div>
              <div class="orderInfo-right"></div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>    
  </div>
</main>