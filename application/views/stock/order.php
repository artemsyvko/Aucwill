<main>
  <div class="inner-main">
    <div class="content-block-lv2">
      <h1 class="hstyle-primary">発送元住所編集</h1>
      <div class="card">
        
        <div class="notice notice-caution custom-mb-15">
          <p>この商品の在庫数は<?= $product['prod_quantity'] ?>個です。</p>
          <p>配達希望日を設定するときは、正しい値を入力してください。</p>
        </div>
        <form action="<?= base_url() ?>stock/order" method="post" id="order-creating-form" enctype="multipart/form-data">
        <input value="<?= $product['id'] ?>" name="prod_id" style="display:none">
        
        <div class="content-block-lv3">
          <h2 class="hstyle-title-bar question">国内発送 ステップ(1)</h2>
          <section class="tips toggle-el">
            <p class="dott">発送したい商品の管理番号を選んでください。</p>
            <p class="dott">「午前9時まで」のご依頼は当日発送になります。それ以降は翌日の発送になります。</p>
            <p class="dott">日曜日は発送を行っておりませんので、土曜日の9時以降は月曜の発送になります。</p>
            <p class="dott">匿名配送には対応しておりません。</p>
            <p class="dott">各プラットフォームで住所がわかるように設定して出品よろしくお願いします。</p>
          </section>

          <h2 class="title-table">商品情報</h2>
          <table class="gray-table-no-border">
            <thead>
              <tr>
                <th>管理番号</th>
                <th>商品名</th>
                <th>数量</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><input type="text" name="prod_management_number" value="<?= $product['prod_management_number'] ?>" readonly></td>
                <td><input type="text" name="prod_name" value="<?= $product['prod_name'] ?>" readonly></td>
                <td><input type="number" name="prod_quantity_out" value="<?= $product['prod_quantity'] ?>" min="1" required></td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="content-block-lv3">
          <h2 class="hstyle-title-bar question">国内発送 ステップ(2)</h2>
          <section class="tips toggle-el">
            <p>商品発送先の住所の入力お願いします。</p>
            <div class="notice notice-caution custom-mb-10">
              <p>
                今依頼すると2023-08-16 に発送予定です。<br>
                <span class="bold">配送希望日＝到着日付指定がある場合はこれより後の日付にしてください。</span>
              </p>
            </div>
            
            <div class="notice notice-caution">
              <p>
                <span class="bold">【郵便局留めにする場合】</span><br>
                宛先には郵便局の住所を入力してください。<br>
                荷受人様の住所が分かる場合は、備考欄に記載して下さい(郵便局推奨)<br>
                ※コンビニ受取、ヤマト運輸センター留め発送は出来ません
              </p>
            </div>
          </section>

          <h2 class="title-table">発送先住所</h2>
          <div>
            <div class="form">
              
              <div class="form-group">
                <div class="form-head">住所入力方法を選択してください</div>
                <div class="form-fill">
                  <label class="wrap-radio" for="shift-jis">
                    <input type="radio" name="address-option" value="qrcode" id="qrcode-radio">QRCode
                  </label>
                  <label class="wrap-radio" for="utf8">
                    <input type="radio" name="address-option" value="text" id="text-radio">文字入力
                  </label>
                </div>
              </div>

              <div class="form-group" id="qrcode-option" style="display: none;">
                <div class="form-head required">QRCode (*.jpg, *.jpeg, *.png)</div>
                <div class="form-fill">
                  <input type="file" class="p-code" name="qrcode" id="buyer_qrcode">
                </div>
              </div>

              <div id="text-option" style="display: none;">
              <div class="form-group">
                <div class="form-head required">宛名</div>
                <div class="form-fill">
                  <input type="text" class="p-name" name="buyer_name" id="buyer_name">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">郵便番号</div>
                <div class="form-fill">
                  <input type="text" class="p-postcode" name="buyer_post_code" id="buyer_post_code">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">都道府県</div>
                <div class="form-fill">
                  <select class="p-region" name="buyer_prefecture" id="buyer_prefecture">
                    <option disabled selected></option>
                    <option value="北海道">北海道</option>
                    <option value="青森県">青森県</option>
                    <option value="岩手県">岩手県</option>
                    <option value="宮城県">宮城県</option>
                    <option value="秋田県">秋田県</option>
                    <option value="山形県">山形県</option>
                    <option value="福島県">福島県</option>
                    <option value="茨城県">茨城県</option>
                    <option value="栃木県">栃木県</option>
                    <option value="群馬県">群馬県</option>
                    <option value="埼玉県">埼玉県</option>
                    <option value="千葉県">千葉県</option>
                    <option value="東京都">東京都</option>
                    <option value="神奈川県">神奈川県</option>
                    <option value="新潟県">新潟県</option>
                    <option value="富山県">富山県</option>
                    <option value="石川県">石川県</option>
                    <option value="福井県">福井県</option>
                    <option value="山梨県">山梨県</option>
                    <option value="長野県">長野県</option>
                    <option value="岐阜県">岐阜県</option>
                    <option value="静岡県">静岡県</option>
                    <option value="愛知県">愛知県</option>
                    <option value="三重県">三重県</option>
                    <option value="滋賀県">滋賀県</option>
                    <option value="京都府">京都府</option>
                    <option value="大阪府">大阪府</option>
                    <option value="兵庫県">兵庫県</option>
                    <option value="奈良県">奈良県</option>
                    <option value="和歌山県">和歌山県</option>
                    <option value="鳥取県">鳥取県</option>
                    <option value="島根県">島根県</option>
                    <option value="岡山県">岡山県</option>
                    <option value="広島県">広島県</option>
                    <option value="山口県">山口県</option>
                    <option value="徳島県">徳島県</option>
                    <option value="香川県">香川県</option>
                    <option value="愛媛県">愛媛県</option>
                    <option value="高知県">高知県</option>
                    <option value="福岡県">福岡県</option>
                    <option value="佐賀県">佐賀県</option>
                    <option value="長崎県">長崎県</option>
                    <option value="熊本県">熊本県</option>
                    <option value="大分県">大分県</option>
                    <option value="宮崎県">宮崎県</option>
                    <option value="鹿児島県">鹿児島県</option>
                    <option value="沖縄県">沖縄県</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">住所</div>
                <div class="form-fill">
                  <input type="text" class="p-address" name="buyer_address" id="buyer_address">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head">アパート名、会社名など</div>
                <div class="form-fill">
                  <input type="text" class="p-building" name="buyer_building" id="buyer_building">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head">電話番号</div>
                <div class="form-fill">
                  <input type="text" class="p-phone" name="buyer_phone" id="buyer_phone">
                </div>
              </div>
              </div>
              <div class="form-group">
                <div class="form-head">配達希望日</div>
                <div class="form-fill">
                  <input type="date" class="p-date" name="arrival_date">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head">配達希望時間</div>
                <div class="form-fill">
                  <select name="arrival_time">
                    <option value="00">なし</option>
                    <option value="51">午前中</option>
                    <option value="52">12~14時</option>
                    <option value="53">14~16時</option>
                    <option value="54">16~18時</option>
                    <option value="55">18~20時</option>
                    <option value="56">20~21時</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-head">備考</div>
                <div class="form-fill">
                  <textarea name="note" id="" rows="3"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="content-block-lv3">
          <h2 class="hstyle-title-bar question">国内発送 ステップ(3)</h2>
          <section class="tips toggle-el">
            <p>発送元情報を正しく入力してください。<a href="/address">発送元登録</a>をご利用いただくと、より便利です。</p>
          </section>

          <h2 class="title-table">発送元住所</h2>
          <div>
            <div class="form">
              <div class="form-group">
                <div class="form-head">登録された発送元住所</div>
                <div class="form-fill">
                  <select class="p-address" name="member_address" id="member_address">
                    <option disabled selected></option>
                    <?php foreach($member_addresses as $address) { ?>
                      <option value="<?= $address['post_code'].':'.$address['prefecture'].':'.$address['address'].':'.$address['building'] ?>">
                        <?= $address['post_code'].$address['prefecture'].$address['address'].$address['building']  ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">郵便番号</div>
                <div class="form-fill">
                  <input type="text" class="p-postcode" name="member_post_code" required>
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">都道府県</div>
                <div class="form-fill">
                  <select class="p-region" name="member_prefecture" required>
                    <option disabled selected></option>
                    <option value="北海道">北海道</option>
                    <option value="青森県">青森県</option>
                    <option value="岩手県">岩手県</option>
                    <option value="宮城県">宮城県</option>
                    <option value="秋田県">秋田県</option>
                    <option value="山形県">山形県</option>
                    <option value="福島県">福島県</option>
                    <option value="茨城県">茨城県</option>
                    <option value="栃木県">栃木県</option>
                    <option value="群馬県">群馬県</option>
                    <option value="埼玉県">埼玉県</option>
                    <option value="千葉県">千葉県</option>
                    <option value="東京都">東京都</option>
                    <option value="神奈川県">神奈川県</option>
                    <option value="新潟県">新潟県</option>
                    <option value="富山県">富山県</option>
                    <option value="石川県">石川県</option>
                    <option value="福井県">福井県</option>
                    <option value="山梨県">山梨県</option>
                    <option value="長野県">長野県</option>
                    <option value="岐阜県">岐阜県</option>
                    <option value="静岡県">静岡県</option>
                    <option value="愛知県">愛知県</option>
                    <option value="三重県">三重県</option>
                    <option value="滋賀県">滋賀県</option>
                    <option value="京都府">京都府</option>
                    <option value="大阪府">大阪府</option>
                    <option value="兵庫県">兵庫県</option>
                    <option value="奈良県">奈良県</option>
                    <option value="和歌山県">和歌山県</option>
                    <option value="鳥取県">鳥取県</option>
                    <option value="島根県">島根県</option>
                    <option value="岡山県">岡山県</option>
                    <option value="広島県">広島県</option>
                    <option value="山口県">山口県</option>
                    <option value="徳島県">徳島県</option>
                    <option value="香川県">香川県</option>
                    <option value="愛媛県">愛媛県</option>
                    <option value="高知県">高知県</option>
                    <option value="福岡県">福岡県</option>
                    <option value="佐賀県">佐賀県</option>
                    <option value="長崎県">長崎県</option>
                    <option value="熊本県">熊本県</option>
                    <option value="大分県">大分県</option>
                    <option value="宮崎県">宮崎県</option>
                    <option value="鹿児島県">鹿児島県</option>
                    <option value="沖縄県">沖縄県</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">住所</div>
                <div class="form-fill">
                  <input type="text" class="p-address" name="member_address" required>
                </div>
              </div>
              <div class="form-group">
                <div class="form-head">アパート名、会社名など</div>
                <div class="form-fill">
                  <input type="text" class="p-building" name="member_building">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">お名前</div>
                <div class="form-fill">
                  <input type="text" class="p-name" name="member_name" required>
                </div>
              </div>
              <div class="form-group">
                <div class="form-head">電話番号</div>
                <div class="form-fill">
                  <input type="text" class="p-phone" name="member_phone">
                </div>
              </div>
            </div>
          </div>

          <div class="check-center custom-mb-15">
            <label>
              <input type="checkbox" value="1" name="in_packet">
              可能な限りゆうパケットでの発送を希望する
            </label>
          </div>
          
          <div class="btn-center">
            <button class="btn btn-primary" id="btn_sender_submit">発送登録する</button>
          </div>
        </div>

        </form>
      </div>
    </div>
  </div>
</main>

<script>
$(document).ready(function(){
  $('#member_address').change(function(){
    var addr = $(this).val();

    var post_code = addr.split(':')[0];
    var prefecture = addr.split(':')[1];
    var address = addr.split(':')[2];
    var building = addr.split(':')[3];

    $("input[name=member_post_code]").val(post_code);
    $("select[name=member_prefecture]").val(prefecture);
    $("input[name=member_address]").val(address);
    $("input[name=member_building]").val(building);
  })
});

$(document).on('click', '#qrcode-radio', function () {
  $('#qrcode-option').show();
  $('#text-option').hide();

  $("#buyer_name").prop("required", false);
  $("#buyer_post_code").prop("required", false);
  $("#buyer_prefecture").prop("required", false);
  $("#buyer_address").prop("required", false);

  $("#buyer_name").val('');
  $("#buyer_post_code").val('');
  $("#buyer_prefecture").val('');
  $("#buyer_address").val('');
  $("#buyer_building").val('');
  $("#buyer_phone").val('');
})

$(document).on('click', '#text-radio', function () {
  $('#qrcode-option').hide();
  $('#text-option').show();

  $("#buyer_name").val('');
  $("#buyer_post_code").val('');
  $("#buyer_prefecture").val('');
  $("#buyer_address").val('');
  $("#buyer_building").val('');
  $("#buyer_phone").val('');

  $("#buyer_name").prop("required", true);
  $("#buyer_post_code").prop("required", true);
  $("#buyer_prefecture").prop("required", true);
  $("#buyer_address").prop("required", true);
})
// const form = document.getElementById('order-creating-form');
// form.addEventListener('submit', function(event) {
//   $.post('order/product-quantity-check', {
//     _method :'POST',
//     prod_id: $("input[name=prod_id]").val(),
//     prod_quantity_out: $("input[name=prod_quantity_out]").val()
//   })
//   .done(function(response) {
//       event.preventDefault();
//       return;
//     // if result is true, can submit
//     if( !response.result ){
//       event.preventDefault();
//       alert(`この商品の在庫数は${response.prod_quantity}個です。`);
//     }      
//   })
//   .fail(function(error) {
//     // handle error response here
//     console.error('AJAX リクエストが失敗しました。');
//   })
// });
</script>