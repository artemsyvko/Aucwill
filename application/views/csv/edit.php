<main>
            
  <div class="inner-main">
    <div class="content-block-lv2">
      <div class="card">
        <h1 class="hstyle-basic">アップロードされたCSVと弊社システムの列名を合わせてください</h1>

        <div class="notice notice-caution" style="margin-bottom: 20px">
          <p>商品名または納品数量を必ず選択してください。</p>
        </div>
        
        <table class="table csv">
          <thead>
            <tr>
              <th>CSVの列名</th>
              <?php 
              foreach($csv_rows[0] as $col){
                echo '<th>'.$col.'</th>';
              }
              ?>
            </tr>
          </thead>
          <tbody>
            <?php 
              foreach($csv_rows as $key => $csv_row){
                if ($key == 0){
                  echo '<tr>';
                  echo '<td>システムの列名</td>';
                  
                  foreach($csv_row as $key1 => $col){
                    echo '<td>'.
                            '<select name="rowName-'.$key1.'" class="form-control rowName">'.
                              '<option selected="selected" value="">選択してください</option>'.
                              '<option value="prod_name">商品名(必須)</option>'.
                              '<option value="prod_quantity_in">納品数量(必須)</option>'.
                              '<option value="prod_price">原価</option>'.
                              '<option value="prod_serial">ナンバリング</option>'.
                              '<option value="is_brand">新品</option>'.
                              '<option value="req_photo">撮影不要</option>'.
                              '<option value="req_measure">採寸不要</option>'.
                              '<option value="req_call">通電不要</option>'.
                              '<option value="memo_a">メモA</option>'.
                              '<option value="memo_b">メモB</option>'.
                            '</select>'.
                          '</td>';
                  }
                  echo '</tr>';
                } else {
                  echo '<tr>';
                  echo '<td></td>';
                  foreach($csv_row as $col){
                    echo '<td>'.$col.'</td>';
                  }
                  echo '</tr>';
                }
              }
            ?>
          </tbody>
        </table>
        <div>
          <button class="btn btn-primary" style="float: right; margin-top: 30px;" id="btn-autosave">納品自動入力を行う</button>
          <div style="clear: both;"></div>
        </div>
      </div>
    </div>
    
  </div>
  <script>
    var newRowHead = new Array(<?= count($csv_rows[0]) ?>);

    $('.rowName').change(function () {
      let rowName = $(this).attr('name');
      newRowHead[Number(rowName.slice(8, rowName.length+1))] = $(this).val();
    });
    
    $(document).on('click', '#btn-autosave', function () {
      if((!newRowHead.includes('prod_name')) || (!newRowHead.includes('prod_quantity_in'))) {
        console.log("商品名または納品数量を必ず選択してください。");
        return;
      }

      $.post('<?= base_url() ?>csv/set-header-name', {
        _method: 'POST',
        // _token: 'doUeWE2GIbUT0kSxHjqHpqU1sFG6dPTneOyqqClz',
        file_path: '<?php echo $file_path; ?>',
        new_row_head: newRowHead
      })
      .done(function(response) {
        if(response.success){
          // console.log('納品が自動入力されました。');
          window.location.href = '/schedule/fill';
        } else {
          console.log('納品が自動入力に失敗しました。');
        }
      })
      .fail(function(error) {
        // handle error response here
        console.error('AJAX リクエストが失敗しました。');
      });
    })
  </script>

</main>