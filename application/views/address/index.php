<main>
            
  <div class="inner-main">
    <div class="content-block-lv2">
      <h1 class="hstyle-primary">登録済み住所一覧</h1>
      <div class="card">
        <div class="content-block-lv3">
          <h2 class="title-table">国内発送元住所</h2>
            
          <div class="notice notice-caution custom-mb-25">
            <p>AUCWILL会員様は必ず1つ以上の配送先住所を登録する必要があります。</p>
          </div>

          <ul class="table-list address mb-20 scroll-shadow">
            <li class="list table-header">
              <div class="table-row bottom-line">
                <div class="table-col postal">郵便番号</div>
                <div class="table-col prefectures">都道府県</div>
                <div class="table-col address1">住所</div>
                <div class="table-col address2">アパート名・会社名など</div>
                <div class="table-col name">お名前</div>
                <div class="table-col tel">電話番号</div>
                <div class="table-col edit"> </div>
                <div class="table-col delete"> </div>
              </div>
            </li>
            <li class="list">
              <?php
                foreach ($member_addresses as $member_address) {
              ?>
                <div class="table-row bottom-line">
                  <div class="table-col postal">
                    <div><?= $member_address['post_code'] ?></div>
                  </div>
                  <div class="table-col prefectures">
                    <div><?= $member_address['prefecture'] ?></div>
                  </div>
                  <div class="table-col address1">
                    <div><?= $member_address['address'] ?></div>
                  </div>
                  <div class="table-col address2">
                    <div><?= $member_address['building'] ?></div>
                  </div>
                  <div class="table-col name">
                    <div><?= $member_address['name'] ?></div>
                  </div>
                  <div class="table-col tel">
                    <div><?= $member_address['phone'] ?></div>
                  </div>
                  <div class="table-col edit">
                    <a class="btn-edit" href="<?= base_url()?>address/<?= $member_address['id'] ?>/edit"><i class="fa fa-pencil"></i></a>
                  </div>
                  <div class="table-col delete">
                    <form method="post" action="<?= base_url()?>address/<?= $member_address['id']; ?>/delete">
                      <input type="hidden" name="_token" value="doUeWE2GIbUT0kSxHjqHpqU1sFG6dPTneOyqqClz">
                      <input type="hidden" name="_method" value="DELETE">
                      <button class="btn-delete"> </button>
                    </form>
                  </div>
                </div>
              <?php
                }
              ?>
            </li>                                                  
          </ul>
          <div class="btn-block btn-right">
            <a class="btn" href="<?= base_url()?>address/create?type=%E5%9B%BD%E5%86%85">新規登録</a>
          </div>
        </div>

        <div class="content-block-lv3" hidden>
          <h2 class="title-table">海外発送元住所</h2>
          <ul class="table-list address mb-20 scroll-shadow">
            <li class="list table-header">
              <div class="table-row bottom-line">
                <div class="table-col postal">郵便番号</div>
                <div class="table-col prefectures">都道府県</div>
                <div class="table-col address1">住所</div>
                <div class="table-col address2">アパート名・会社名など</div>
                <div class="table-col name">お名前</div>
                <div class="table-col tel">電話番号</div>
                <div class="table-col edit"> </div>
                <div class="table-col delete"> </div>
              </div>
            </li>
            <li class="list">
                <div class="table-row bottom-line">
                  <div class="table-col postal">
                    <div>1760021</div>
                  </div>
                  <div class="table-col prefectures">
                    <div>Tokyo</div>
                  </div>
                  <div class="table-col address1">
                    <div>NERIMA KU NUKUI 3-28-5</div>
                  </div>
                  <div class="table-col address2">
                    <div>SUNRISE FUJIMI 401</div>
                  </div>
                  <div class="table-col name">
                    <div>TAKAHIRO BANDO</div>
                  </div>
                  <div class="table-col tel">
                    <div>08063580709</div>
                  </div>

                  <div class="table-col edit">
                    <a class="btn-edit" href="<?= base_url()?>address/2028/primary"> 
                      <span class="material-icons-outlined" style="color: lightgrey">star</span>
                    </a>
                    <a class="btn-edit" href="<?= base_url()?>address/2028/edit">
                      <span class="material-icons-outlined">edit</span>
                    </a>
                  </div>
                  <div class="table-col delete">
                    <form method="post" action="<?= base_url()?>address/2028">
                      <input type="hidden" name="_token" value="doUeWE2GIbUT0kSxHjqHpqU1sFG6dPTneOyqqClz">
                      <input type="hidden" name="_method" value="DELETE">
                      <button class="btn-delete"> </button>
                    </form>
                  </div>
                </div>
              </li>
            </ul>
          <div class="btn-block btn-right">
            <a class="btn" href="<?= base_url()?>address/create?type=%E6%B5%B7%E5%A4%96">新規登録</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>