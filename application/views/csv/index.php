<main>
            
  <div class="inner-main">
    <div class="content-block-lv2">
      <div class="card">
        <h1 class="hstyle-basic">[CSVアップロードに関する注意事項]</h1>
        <ul class="circle mb-20">
          <li>Microsoft Office ExcelでCSVを作成してください、他のソフトで作成したCSVは読み取れない可能性があります。</li>
          <li>Windowsで作成した場合は文字コード選択時にShift_JIS、Macで作成した場合はUTF-8を選んでアップロードお願いします。</li>
          <li>数字の入力はすべて「半角」でお願いします。</li>
          <li>必ず1行目にヘッダー行を入れてください。</li>
          <li>原価を入力する場合は半角数字のみです。カンマ入力、空欄はNGとなります。0円の場合は0を入力してください。<a target="_blank" href="<?php echo base_url()?>assets/images/csv-example-1.jpg" class="blue popup-image" data-modaal-desc="原価を入力する場合の入力例">【入力例はこちら】</a> </li>
          <li>原価を後で入力する場合は省略してください。<a target="_blank" href="<?php echo base_url()?>assets/images/csv-example-2.jpg" class="blue popup-image" data-modaal-desc="原価を後で入力する場合の入力例">【入力例はこちら】</a> </li>
        </ul>
        <div class="notice notice-caution">
          <p>一度納品した商品をオークウィルで2個に分けたり、2個を1個にしたりという事はできませんのでご注意ください。<br>また、バッテリーのみの納品はご注意ください。カメラ撮影時に基本的にはセット撮影（例：初心者セット等）はお受けできかねます。どうしてもセット撮影が必要な場合は手数料500円を頂きます。<br>発送依頼前にご連絡が必須となり、発送依頼後はセット対応が行えませんのでご了承ください。</p>
        </div>
      </div>
    </div>
    <form action="<?php echo base_url(); ?>csv/upload" method="post" class="content-block-lv2" enctype="multipart/form-data">
      <input type="hidden" name="_token" value="doUeWE2GIbUT0kSxHjqHpqU1sFG6dPTneOyqqClz">      
      <h1 class="hstyle-primary">CSVアップロード</h1>
      <div class="card">
        <div class="form">
          <div class="form-group">
            <div class="form-head">文字コードを選択 </div>
            <div class="form-fill">
              <label class="wrap-radio" for="shift-jis">
                <input type="radio" name="encoding" value="sjis" id="shift-jis">Shift_JIS
              </label>
              <label class="wrap-radio" for="utf8">
                <input type="radio" name="encoding" value="utf8" id="utf8">UTF-8
              </label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-head">CSVファイルを選択 </div>
            <div class="form-fill">
              <input type="file" id="file" name="csv_file">
            </div>
          </div>
        </div>
        <div class="btn-block btn-center">
          <button class="btn btn-upload" style="color:white;">CSVをアップロード</button>
        </div>
      </div>
    </form>
  </div>
  <script>
    $('#file').change(function () {
      $('#form').submit()
    })
  </script>

</main>