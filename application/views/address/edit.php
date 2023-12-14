<main>
  <div class="inner-main">
    <div class="content-block-lv2">
      <h1 class="hstyle-primary">発送元住所編集</h1>
      <div class="card">
        <div class="content-block-lv3">
          <form action="<?= base_url() ?>address/update" method="post">
            <div class="form mb-50">
              <div class="form-group" style="display:none">
                <div class="form-head required">発送元ID </div>
                <div class="form-fill">
                <input type="text" class="p-type" style="cursor: not-allowed" name="address_id" readonly value="<?= $member_address['id'] ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">種別 </div>
                <div class="form-fill">
                  <input type="text" class="p-type" style="cursor: not-allowed" name="delivery_type" readonly value="国内">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">郵便番号 </div>
                <div class="form-fill">
                  <input type="text" class="p-postal-code" name="post_code" value="<?= $member_address['post_code'] ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">都道府県 </div>
                <div class="form-fill">
                  <!-- <input type="text" class="p-prefecture" name="prefecture"> -->
                  <select class="p-region" class="p-prefecture" name="prefecture" value="<?= $member_address['prefecture'] ?>" required>
                    <option disabled selected></option>
                    <option value="北海道" <?= $member_address['prefecture']=='北海道'?'selected':'' ?> >北海道</option>
                    <option value="青森県" <?= $member_address['prefecture']=='青森県'?'selected':'' ?> >青森県</option>
                    <option value="岩手県" <?= $member_address['prefecture']=='岩手県'?'selected':'' ?> >岩手県</option>
                    <option value="宮城県" <?= $member_address['prefecture']=='宮城県'?'selected':'' ?> >宮城県</option>
                    <option value="秋田県" <?= $member_address['prefecture']=='秋田県'?'selected':'' ?> >秋田県</option>
                    <option value="山形県" <?= $member_address['prefecture']=='山形県'?'selected':'' ?> >山形県</option>
                    <option value="福島県" <?= $member_address['prefecture']=='福島県'?'selected':'' ?> >福島県</option>
                    <option value="茨城県" <?= $member_address['prefecture']=='茨城県'?'selected':'' ?> >茨城県</option>
                    <option value="栃木県" <?= $member_address['prefecture']=='栃木県'?'selected':'' ?> >栃木県</option>
                    <option value="群馬県" <?= $member_address['prefecture']=='群馬県'?'selected':'' ?> >群馬県</option>
                    <option value="埼玉県" <?= $member_address['prefecture']=='埼玉県'?'selected':'' ?> >埼玉県</option>
                    <option value="千葉県" <?= $member_address['prefecture']=='千葉県'?'selected':'' ?> >千葉県</option>
                    <option value="東京都" <?= $member_address['prefecture']=='東京都'?'selected':'' ?> >東京都</option>
                    <option value="神奈川県" <?= $member_address['prefecture']=='神奈川県'?'selected':'' ?> >神奈川県</option>
                    <option value="新潟県" <?= $member_address['prefecture']=='新潟県'?'selected':'' ?> >新潟県</option>
                    <option value="富山県" <?= $member_address['prefecture']=='富山県'?'selected':'' ?> >富山県</option>
                    <option value="石川県" <?= $member_address['prefecture']=='石川県'?'selected':'' ?> >石川県</option>
                    <option value="福井県" <?= $member_address['prefecture']=='福井県'?'selected':'' ?> >福井県</option>
                    <option value="山梨県" <?= $member_address['prefecture']=='山梨県'?'selected':'' ?> >山梨県</option>
                    <option value="長野県" <?= $member_address['prefecture']=='長野県'?'selected':'' ?> >長野県</option>
                    <option value="岐阜県" <?= $member_address['prefecture']=='岐阜県'?'selected':'' ?> >岐阜県</option>
                    <option value="静岡県" <?= $member_address['prefecture']=='静岡県'?'selected':'' ?> >静岡県</option>
                    <option value="愛知県" <?= $member_address['prefecture']=='愛知県'?'selected':'' ?> >愛知県</option>
                    <option value="三重県" <?= $member_address['prefecture']=='三重県'?'selected':'' ?> >三重県</option>
                    <option value="滋賀県" <?= $member_address['prefecture']=='滋賀県'?'selected':'' ?> >滋賀県</option>
                    <option value="京都府" <?= $member_address['prefecture']=='京都府'?'selected':'' ?> >京都府</option>
                    <option value="大阪府" <?= $member_address['prefecture']=='大阪府'?'selected':'' ?> >大阪府</option>
                    <option value="兵庫県" <?= $member_address['prefecture']=='兵庫県'?'selected':'' ?> >兵庫県</option>
                    <option value="奈良県" <?= $member_address['prefecture']=='奈良県'?'selected':'' ?> >奈良県</option>
                    <option value="和歌山県" <?= $member_address['prefecture']=='和歌山県'?'selected':'' ?> >和歌山県</option>
                    <option value="鳥取県" <?= $member_address['prefecture']=='鳥取県'?'selected':'' ?> >鳥取県</option>
                    <option value="島根県" <?= $member_address['prefecture']=='島根県'?'selected':'' ?> >島根県</option>
                    <option value="岡山県" <?= $member_address['prefecture']=='岡山県'?'selected':'' ?> >岡山県</option>
                    <option value="広島県" <?= $member_address['prefecture']=='広島県'?'selected':'' ?> >広島県</option>
                    <option value="山口県" <?= $member_address['prefecture']=='山口県'?'selected':'' ?> >山口県</option>
                    <option value="徳島県" <?= $member_address['prefecture']=='徳島県'?'selected':'' ?> >徳島県</option>
                    <option value="香川県" <?= $member_address['prefecture']=='香川県'?'selected':'' ?> >香川県</option>
                    <option value="愛媛県" <?= $member_address['prefecture']=='愛媛県'?'selected':'' ?> >愛媛県</option>
                    <option value="高知県" <?= $member_address['prefecture']=='高知県'?'selected':'' ?> >高知県</option>
                    <option value="福岡県" <?= $member_address['prefecture']=='福岡県'?'selected':'' ?> >福岡県</option>
                    <option value="佐賀県" <?= $member_address['prefecture']=='佐賀県'?'selected':'' ?> >佐賀県</option>
                    <option value="長崎県" <?= $member_address['prefecture']=='長崎県'?'selected':'' ?> >長崎県</option>
                    <option value="熊本県" <?= $member_address['prefecture']=='熊本県'?'selected':'' ?> >熊本県</option>
                    <option value="大分県" <?= $member_address['prefecture']=='大分県'?'selected':'' ?> >大分県</option>
                    <option value="宮崎県" <?= $member_address['prefecture']=='宮崎県'?'selected':'' ?> >宮崎県</option>
                    <option value="鹿児島県" <?= $member_address['prefecture']=='鹿児島県'?'selected':'' ?> >鹿児島県</option>
                    <option value="沖縄県" <?= $member_address['prefecture']=='沖縄県'?'selected':'' ?> >沖縄県</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">住所 </div>
                <div class="form-fill">
                  <input type="text" class="p-address" name="address" value="<?= $member_address['address'] ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head">アパート名、会社名など </div>
                <div class="form-fill">
                  <input type="text" class="p-building" name="building" value="<?= $member_address['building'] ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">お名前 </div>
                <div class="form-fill">
                  <input type="text" class="p-name" name="name" value="<?= $member_address['name'] ?>">
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">電話番号 </div>
                <div class="form-fill">
                  <input type="text" class="p-phone" name="phone" value="<?= $member_address['phone'] ?>">
                </div>
              </div>
            </div>
            <div class="btn-center">
              <button class="btn btn-primary" id="btn_sender_submit">更新する</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>