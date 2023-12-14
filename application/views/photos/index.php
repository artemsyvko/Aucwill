<main>            
  <div class="inner-main">
    <div class="content-block-lv2">
      <h1 class="hstyle-primary">撮影済写真</h1>
      <div class="card">
        <div class="content-block-lv1">
          <h2 class="hstyle-title-bar question">注意点</h2>
          <section class="tips toggle-el">
            <p class="notes mb-20"><span class="bold">納品した写真データと、商品名が一致しているか必ずご確認下さい。</span><br>納品間違いに気づいた場合、なるべく早くご連絡下さい。<br>納品写真と商品名が一致しておらず、そのまま販売、誤商品が発送された場合でもオークウィルではその分の補償を致しかねます。<br>納品の最終確認は会員様の責任でお願い致します。</p>
            <p class="notes mb-20"><span class="bold">納品メールから3営業日を過ぎても写真データ納品が無い場合、一度ご連絡下さい。</span><br>納品から1カ月以内＝無料で画像データ再送可能<br>納品から1カ月以上経過＝データ再送&amp;再撮影には1点×手数料500円が発生</p>
            <p class="notes"><span class="bold">写真データのダウンロード可能期間は、納品から1週間です。</span><br>それを過ぎると会員画面からダウンロード出来なくなりますのでご注意下さい。<br>再送希望の場合、直接メールにてご連絡下さい。</p>
          </section>

          <div class="content-block-lv2">

            <?php if(count($photos) > 0) { ?>
            
            <table class="schedule-tbl prod-photo-tbl gray-table-no-border">
              <thead>
                <tr>
                  <th class="prod-photo text-center">商品写真</th>
                  <th class="text-center">商品名</th>
                  <th class="text-center">枚数</th>
                  <th class="text-center">管理番号</th>
                  <th class="text-center">撮影日</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach($photos as $photo) {
                ?>
                <tr>
                  <td class="prod-photo text-center"><img src="<?= base_url('uploads/photo/').$photo['path'][0]['filename'] ?>" class="product-thumbnail" alt="<?= $photo['prod_name'] ?>" /></td>
                  <td class="text-center"><?= $photo['prod_name'] ?></td>
                  <td class="text-center"><?= count($photo['path']) ?></td>
                  <td class="text-center"><?= $photo['prod_management_number'] ?></td>
                  <td class="text-center"><?= $photo['path'][0]['created_at'] ?></td>
                  <td class="text-center"></td>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>

            
            <form action="<?= base_url() ?>photos/download">
            <div>
              <div class="text-center custom-mb-15">
                <button type="submit" class="btn btn-custom-download">撮影データダウンロード</button>
              </div>
              <p class="text-center fs-sm custom-fs-13">※ファイル形式はZIPファイルになります。</p>
            </div>
            </form>

            <?php } else { ?>
              <!-- No Product Photos -->
              <p>最近納品した商品の画像がありません。</p>
            <?php } ?>

          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .scroll-limit li:nth-child(n+10) {
      display: none;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.min.js"></script>
  <script>
    lazyload();
    $('.toggle').click(function () {
        $(this).parents('table').find('.over10').toggle()
    })
    $('.show-all').click(function () {
      $(this).parent().find('.scroll-limit').removeClass('scroll-limit')
    })
  </script> 
</main>