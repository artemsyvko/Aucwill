<main>    
  <div class="inner-main">
    <div class="content-block-lv2">
      <h1 class="hstyle-primary">新規住所登録</h1>
      <div class="card">
        <div class="content-block-lv3">
          <div class="row">
              <div class="col-md-12">
                  <?= validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>') ?>
              </div>
          </div>
          <form action="<?= base_url() ?>address/create" method="post">
            <div class="form mb-50">
              <div class="form-group">
                <div class="form-head required">種別 </div>
                <div class="form-fill">
                  <input type="text" class="p-type" style="cursor: not-allowed" name="delivery_type" readonly value="国内">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">郵便番号 </div>
                <div class="form-fill">
                  <input type="text" class="p-postal-code" name="post_code" value="<?= isset($post_code)?$post_code:'' ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">都道府県 </div>
                <div class="form-fill">
                  <select class="p-region" class="p-prefecture" name="prefecture" required>
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
                <div class="form-head required">住所 </div>
                <div class="form-fill">
                  <input type="text" class="p-address" name="address"  value="<?= isset($address)?$address:'' ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head">アパート名、会社名など </div>
                <div class="form-fill">
                  <input type="text" class="p-building" name="building"  value="<?= isset($building)?$building:'' ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">お名前 </div>
                <div class="form-fill">
                  <input type="text" class="p-name" name="name"  value="<?= isset($name)?$name:'' ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">電話番号 </div>
                <div class="form-fill">
                  <input type="text" class="p-phone" name="phone"  value="<?= isset($phone)?$phone:'' ?>">
                </div>
              </div>
            </div>
            <div class="btn-center">
              <button class="btn btn-primary" id="btn_sender_submit">保存する</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>