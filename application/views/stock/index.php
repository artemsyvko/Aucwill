<main>
  <div class="inner-main">
    <p class="single-product-warning">同梱依頼出来ません。単一の商品をお選びください。</p>

    <div class="content-block-lv2">
      <div class="wrap-headline-col2">
        <h1 class="hstyle-primary">在庫一覧</h1>
          <div class="func">
            <form action="<?= base_url() ?>stock/csv-in-stock">
              <button class="textlink download" name="export">CSVダウンロード</button>
            </form>
            <div class="wrap-search" style="display: none;">
              <input type="text" name="search" placeholder="キーワード検索">
              <input type="hidden" name="sold" value="">
              <button class="btn navy">検索 </button>
            </div>
          </div>
      </div>

      <div class="card">
        <div class="wrap-tab">
          <a class="tab active" href="<?php echo base_url() ?>stock">在庫中</a>
        </div>
        <div class="wrap-memo">
          <label>
            <input class="switch-memo" type="checkbox">原価・メモを編集
          </label>
          <div class="btn-question">
            <img src="<?php echo base_url()?>assets/images/icon-qeustion.svg" alt="">
          </div>
        </div>
        <!-- <div class="wrap-search mb-30">
          <input type="text" id="quick-search" placeholder="クイック検索">
        </div> -->
        <section class="tips toggle-el">
          <dl class="tips">
            <p>原価、メモ欄は会員様にてご自由にお使いください。<br>原価を入力しておくと決算時の棚卸しに便利です。<br>入力をお勧め致します。<br>【原価、メモ欄は弊社スタッフ側で閲覧できません 連絡事項は記載しないで下さい】</p>
          </dl>
        </section>
        <ul class="table-list item mb-20 scroll-shadow">
          <li class="list table-header">
            <div class="table-row bottom-line">
              <div class="table-col send">発送</div>
              <div class="table-col photo"> </div>
              <div class="table-col m-num">管理番号</div>
              <div class="table-col name">商品名</div>
              <div class="table-col numbering">ナンバリング</div>
              <div class="table-col quantity tx-right">数量</div>
              <div class="table-col info">情報</div>
              <!-- <div class="table-col date">撮影日</div> -->
            </div>
          </li>
          
          <?php foreach ($products as $product) { ?>
            <li class="list item-layout">
              <label class="checkbox">
                <input class="check-send" type="checkbox" value="<?= $product[0]['id'] ?>">
              </label>
              <div class="input-container">
                <div class="table-row">
                  <div class="table-col photo">
                    <img class="product-thumbnail" src="<?= $product[1]['thumbnail'] ?>">
                  </div>
                  <div class="table-col m-num"><a class="contactForm1 blue" id="management-number-<?= $product[0]['id'] ?>" href="#"><?= $product[0]['prod_management_number'] ?></a></div>
                  <div class="table-col name">
                    <div id="prod-name-<?= $product[0]['id'] ?>"><?= $product[0]['prod_name'] ?></div>
                  </div>
                  <div class="table-col numbering">
                    <div><?= $product[0]['prod_serial'] ?></div>
                  </div>
                  <div class="table-col quantity tx-right">
                    <div><?= $product[0]['prod_quantity'] ?></div>
                  </div>
                  <div class="table-col info">
                    <div>
                      <?= $product[0]['is_brand']?'新品':'中古' ?>
                      <br>
                      <?= $product[0]['req_photo'] == 2 ? '撮影した<br>' : '' ?>
                      <?= $product[0]['req_measure'] == 2 ? '採寸した<br>' : '' ?>
                      <?= $product[0]['req_call'] == 2 ? '通電<br>' : '' ?>
                      <!-- <br>サイズ60 -->
                    </div>
                  </div>
                  <!-- <div class="table-col date">
                    <div></div>
                  </div> -->
                </div>
                <div class="memo stock-memo" style="display: none;">
                  <dl class="list-subInfo">
                    <dt>原価</dt>
                    <dd>
                      <input class="bg-blue memo" name="prod_price-<?= $product[0]['id'] ?>" value="<?= $product[0]['prod_price'] ?>" type="number" style="display: none;">
                    </dd>
                  </dl>
                  <dl class="list-subInfo">
                    <dt>採寸</dt>
                    <dd>
                      <input class="bg-blue memo" name="prod_measure-<?= $product[0]['id'] ?>" value="<?= $product[2]['measure'] ?>" type="text" style="display: none;" <?= $product[0]['req_measure'] >= 1 ? '' : 'disabled' ?>>
                    </dd>
                  </dl>
                  <dl class="list-subInfo">
                    <dt>メモA</dt>
                    <dd>
                      <input class="bg-blue memo" name="memo_a-<?= $product[0]['id'] ?>" value="<?= $product[0]['memo_a'] ?>" type="text" style="display: none;">
                    </dd>
                  </dl>
                  <dl class="list-subInfo">
                    <dt>メモB</dt>
                    <dd>
                      <input class="bg-blue memo" name="memo_b-<?= $product[0]['id'] ?>" value="<?= $product[0]['memo_b'] ?>" type="text" style="display: none;">
                    </dd>
                  </dl>
                </div>
              </div>
            </li>
          <?php }?>
        </ul>
      </div>
    </div>

    
    <div class="out-div" style="display:none">
      <div class="info-modal" id="inquiry-modal">
        <span onclick="closeEnquiryModal()" id="inquiry-modal-close-button">X</span>
        <h3>お問い合わせ</h3>

        <form action="<?= base_url() ?>enquiry/create" method="post">
          <div class="form custom-mb-25">
            <input style="display:none" name="parent" value="0">
            <div class="form-group">
                <div class="form-head required">件名 </div>
                <div class="form-fill">
                    <input type="text" id="enquiry-subject" class="p-type" name="subject" required>
                </div>
            </div>
            <div class="form-group">
                <div class="form-head">分類</div>
                <div class="form-fill">
                <select name="category" style="pointer-events: none;">
                    <option value="0" selected>商品</option>
                    <option value="1">納品</option>
                    <option value="2">配送</option>
                    <option value="3">アカウント</option>
                    <option value="4">その他</option>
                </select>
                </div>
            </div>
            <div class="form-group">
                <div class="form-head required">お問い合わせ内容</div>
                <div class="form-fill">
                    <textarea name="content" id="" rows="4" required></textarea>
                </div>
            </div>
          </div>

          <div class="btn-center">
              <button class="btn btn-primary">送信する</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <form action="/stock/order" id="schedule-form" method="get">
  <div class="bottom-fixnav">
    <div class="inner">
        <input type="hidden" name="prod_ids" id="prod_ids" value=","/>
        <!-- <button class="btn navy" id="kokunai" type="button">選択中を国内発送する </button>
        <button class="btn green" id="kaigai" type="button"> 選択中を海外発送する </button> -->
        <button class="btn green" id="kokunai" type="button">選択中を国内発送する </button>
    </div>
  </div>
  </form>
</main>

<script>
$(document).on('change', 'input.bg-blue.memo', function () {
  var name = $(this).attr('name');
  var value = $(this).val();
  
  $.post('<?= base_url() ?>stock/product_update', {
    _method :'POST',
    // _token : 'doUeWE2GIbUT0kSxHjqHpqU1sFG6dPTneOyqqClz',
    name: name,
    value: value
  })
  .done(function(response) {
    if(response.success){
      console.log('商品情報が更新されました。');
    } else {
      console.log('商品情報の更新に失敗しました。');
    }
    
  })
  .fail(function(error) {
    // handle error response here
    console.error('AJAX リクエストが失敗しました。');
  })
});

$(document).on('click', '.check-send', function () {
  var e_prod_ids = $('#prod_ids');
  var prod_ids = e_prod_ids.val();
  var prod_id = $(this).val();

  if (prod_ids == '') {
    e_prod_ids.val(',');
  }

  if (prod_ids.indexOf(prod_id) > -1) {
    e_prod_ids.val(e_prod_ids.val().replace(',' + prod_id + ',', ','));
  } else {
    e_prod_ids.val(e_prod_ids.val() + prod_id + ',');
  }
  $('#prod_id').val($('#prod_id').val() + prod_id + ',');
});

$(document).on('click', '#kokunai', function (event) {
  event.preventDefault();
  
  var prod_ids = $('#prod_ids').val();
  if (prod_ids.split(',').length > 3) {
    $('.single-product-warning').show();
    return;
  } else {
    $('.single-product-warning').hide();
    $('#schedule-form').submit();
  }
});

$(document).ready(function() {
    var checkboxes = $('.check-send');

    checkboxes.each(function() {
        $(this).prop('checked', false);
    });

});

$(document).on('click', '.contactForm1', function() {
  var prod_id = $(this).attr('id').split('-')[2];
  var prod_management_number = $(this).text();
  var prod_name = $('#prod-name-'+prod_id).text();

  var subject = `${prod_name}(${prod_management_number})について問い合わせます`;

  $('#enquiry-subject').val(subject);
  document.getElementsByClassName('out-div')[0].style.display = "flex";
  document.getElementsByClassName('out-div')[0].style.zIndex = "999";
})

function openEnquiryModal(id) {
}

function closeEnquiryModal() {
  document.getElementsByClassName('out-div')[0].style.display = "none";
  document.getElementsByClassName('out-div')[0].style.zIndex = "-1";
}
</script>