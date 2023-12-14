<main>
  <div id="app" class="inner-main">
    <div class="content-block-lv2">
      <h1 class="hstyle-primary">新規会員登録</h1>
      <div class="card">
      <div class="content-block-lv3">
        <div class="notice notice-warning" style="display: <?=$is_new ? 'none' : 'block'?>">
            <p>エラーです。同じメールが存在します!</p>
        </div>
        <div class="notice notice-info" style="display: <?=$created==false ? 'none' : 'block'?>">
            <p>新規会員<?=$created?>が新たに登録されました。</p>
        </div>

        <div style="width: 100%; text-align: right; padding-top: 15px; padding-bottom: 15px;"><a href="<?=base_url()?>users" class="member-register-btn">会員リスト</a></div>
        
        <form action="<?= base_url() ?>cuser" method="post">
            <div class="form mb-50">
              <div class="form-group">
                <div class="form-head required">お名前 </div>
                <div class="form-fill">
                  <input type="text" class="u-name" name="name"  value="<?= isset($name)?$name:'' ?>" required>
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">Eメール </div>
                <div class="form-fill">
                  <input type="text" class="u-email" name="email"  value="<?= isset($email)?$email:'' ?>" required>
                </div>
              </div>
              <div class="form-group">
                <div class="form-head required">会社名 </div>
                <div class="form-fill">
                  <input type="text" class="u-company" name="company"  value="<?= isset($company)?$company:'' ?>" required>
                </div>
              </div>
            </div>
            <div class="btn-center">
              <button class="btn btn-primary" id="btn_sender_submit">会員登録</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
