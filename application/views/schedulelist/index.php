<main>
  <div class="inner-main">
    <div class="content-block-lv2">
      <h1 class="hstyle-primary">納品予定一覧</h1>
      <div class="card">
        <div class="notice notice-info mb-20">
          <p>原価、メモ欄は会員様にてご自由にお使いください。原価を入力しておくと決算時の棚卸しに便利な為、入力をお勧め致します。<br>【原価、メモ欄は弊社スタッフ側で閲覧できません 連絡事項は記載しないで下さい】</p>
        </div>
        <?php foreach($schedules as $schedule){
          if (count($schedule['products']) == 0) continue;
          ?>
          <ul class="table-list arrival-box-list mb-20 parant-list-add scroll-shadow" id="schedule-<?= $schedule['schedule']['id'] ?>">
            <form>
              <li>
                配送業者: <?= $schedule['transfer'] ?> &nbsp 追跡番号: <?= $schedule['schedule']['tracking_number'] ?>
              </li>
              <button class="btn btn-danger float-right btn-schedule-list-delete" onclick="removeSchedule(<?= $schedule['schedule']['id'] ?>)">
                このグループの納品予定を削除
              </button>
            </form>
            <li class="list table-header">
              <div class="table-row bottom-line">
                <div class="table-col m-id">管理ID</div>
                <div class="table-col name">商品名</div>
                <div class="table-col num">ナンバリング</div>
                <div class="table-col quantity">数量</div>
                <div class="table-col new">新品</div>
                <div class="table-col photo">撮影</div>
                <div class="table-col measure">採寸</div>
                <div class="table-col call">通電</div>
                <div class="table-col delete"></div>
              </div>
            </li>
            <?php foreach($schedule['products'] as $product){ ?>
            <li class="list scheduled-product" id="scheduled-product-<?= $product['id'] ?>">
              <div class="table-row">
                <div class="table-col">
                  <span><?= $schedule['schedule']['id'] ?></span>
                </div>
                <div class="table-col name">
                  <span><input type="text" id="product-product_name-<?= $product['id'] ?>" name="prod_name-<?= $product['id'] ?>" value="<?= $product['prod_name'] ?>"/></span>
                </div>
                <div class="table-col num">
                  <span><?= $product['prod_serial'] ?></span>
                </div>
                <div class="table-col quantity">
                  <span><?= $product['prod_quantity_in'] ?></span>
                </div>
                <div class="table-col new">
                  <span>
                    <?= $product['is_brand'] ? "新品" : "古品" ?>
                  </span>
                </div>
                <div class="table-col photo">
                  <span style="width: 100px;">
                    <?= $product['req_photo'] ? "要撮影" : "撮影不要" ?>
                  </span>
                </div>
                <div class="table-col photo">
                  <span style="width: 100px;">
                    <?= $product['req_measure'] ? "要採寸" : "採寸不要" ?>
                  </span>
                </div>
                <div class="table-col photo">
                  <span style="width: 100px;">
                    <?= $product['req_call'] ? "要通電" : "通電不要" ?>
                  </span>
                </div>
                <div class="table-col delete">
                  <button type="button" class="btn-delete" onclick="removeScheduledProduct(<?= $product['id'] ?>, <?= $schedule['schedule']['id'] ?>)"></button>
                </div>
              </div>
              <div class="list-subInfo input-schdulelist">
                <label>原価</label>
                <input type="number" id="product-price-<?= $product['id'] ?>" name="prod_price-<?= $product['id'] ?>" value="<?= $product['prod_price'] ?>">
              </div>
              <div class="list-subInfo input-schdulelist">
                <label>メモA</label>
                <input type="text" id="product-memo_a-<?= $product['id'] ?>" name="memo_a-<?= $product['id'] ?>" value="<?= $product['memo_a'] ?>">
              </div>
              <div class="list-subInfo input-schdulelist">
                <label>メモB</label>
                <input type="text" id="product-memo_b-<?= $product['id'] ?>" name="memo_b-<?= $product['id'] ?>" value="<?= $product['memo_b'] ?>">
              </div>
            </li>
            <?php } ?>
          </ul>
        <?php } ?>
      </div>
    </div>
  </div>
  <script>
    function removeScheduledProduct(productId, scheduleId){
      $.ajax({
        url: '<?= base_url()?>schedulelist/delete_scheduled_product',
        type: 'POST',
        data: {prod_id: productId},
        success: function(response) {
          if (response.success) {
            $('#scheduled-product-' + productId).remove();

            let currentProductCount = $('#schedule-' + scheduleId).children('.scheduled-product').length;
            if (currentProductCount == 0) {
              removeSchedule(scheduleId);
              console.log('この予定の最後の製品は削除されました。');
              $('#schedule-' + scheduleId).remove();
            }
          } else {
            console.log('予定製品の削除に失敗しました。');
          }
        },
        error: function () {
          console.log('AJAX リクエストが失敗しました。');
        }
      });
    }


    function removeSchedule(scheduleId){
      $.ajax({
        url: '<?= base_url() ?>schedulelist/delete',
        type: 'POST',
        data: {schedule_id: scheduleId},
        success: function(response) {
          if (response.success) {
            $('#schedule-' + scheduleId).remove();
          } else {
            alert('予定の削除に失敗しました。');
            console.log('予定の削除に失敗しました。');
          }
        },
        error: function (err) {
          alert('AJAX リクエストが失敗しました。');
          console.log(err);
        }
      });
    }

    $(document).on('change', 'input', function () {
      var name = $(this).attr('name');
      var value = $(this).val();
      
      $.post('<?= base_url() ?>schedulelist/product_update', {
        _method :'POST',
        // _token : 'doUeWE2GIbUT0kSxHjqHpqU1sFG6dPTneOyqqClz',
        name: name,
        value: value
      })
      .done(function(response) {
        if(response.success){
          console.log('製品予約属性が更新されました。');
        } else {
          console.log('製品予約属性の更新に失敗しました。');
        }
        
      })
      .fail(function(error) {
        // handle error response here
        console.error('AJAX リクエストが失敗しました。');
      })
    })
  </script>
</main>