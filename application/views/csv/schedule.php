<main>
  <div id="app" class="inner-main">
    <div class="content-block-lv2">
      <div class="alert alert-info" role="alert">
        CSVより納品指示商品を取り込みました。必ず内容を確認の上「保存」をおしてください。
      </div>
      <h1 class="hstyle-primary">納品先住所</h1>
      <div class="card">
        <div class="form mb-30">
          <div class="form-group">
            <div class="form-head">郵便番号 </div>
            <div class="form-fill"><?= ADMIN_POST_CODE ?></div>
          </div>
          <div class="form-group">
            <div class="form-head">住所 </div>
            <div class="form-fill"><?= ADMIN_PREFECTURE.ADMIN_ADDRESS.ADMIN_BUILDING?>　<?= ADMIN_NAME ?> 宛て</div>
          </div>
        </div>
        <div class="notice notice-warning">
          <p>オークウィルへ発送する場合は会員様のお名前でお願いします。</p>
        </div>
      </div>
    </div>

    <form method="post" action="<?= base_url()?>csv/update_csv_schedule" id="send-schedule-form" class="content-block-lv2">
      <input type="hidden" name="schedule_id" id="schedule-id" value="<?= $schedule['id']?>">
      <?php
      $ids = ',';
      foreach ($products as $product) {
        $ids .= $product['id'] . ','; // concatenate each id with a comma separator
      }
      ?>
      <input type="hidden" name="product_list_ids" id="product-list-ids" value="<?= $ids?>">
      <input type="hidden" name="_token" value="doUeWE2GIbUT0kSxHjqHpqU1sFG6dPTneOyqqClz"> 
      <h1 class="hstyle-primary">納品指示</h1>
      <div class="card">
        <div class="content-block-lv2">
          <div class="notice notice-caution mb-10">
            <p>【お願い】納品指示は弊社に到着する箱ごとに記入してください。</p>
          </div>
          <div class="notice notice-caution">
            <p>一度納品した商品をオークウィルで2個に分けたり、2個を1個にしたりという事はできませんのでご注意ください。<br>また、バッテリーのみの納品はご注意ください。カメラ撮影時に基本的にはセット撮影（例：初心者セット等）はお受けできかねます。どうしてもセット撮影が必要な場合は手数料500円を頂きます。<br>発送依頼前にご連絡が必須となり、発送依頼後はセット対応が行えませんのでご了承ください。</p>
          </div>
        </div>
        <div class="content-block-lv1">
          <h2 class="hstyle-title-bar question">納品予定商品の登録</h2>
          <section class="tips toggle-el">
            <p class="mb-10">弊社に納品予定の商品のリストをご登録ください。登録に必要な情報は次の通りです。</p>
            <dl class="tips">
              <dt>●商品名</dt>
              <dd>商品名や、型番などをご入力ください。</dd>
              <dt>●ナンバリング</dt>
              <dd>
                似たような商品が同梱されて到着された場合に弊社にて判断ができない場合がございます。<br>商品に番号を振った付箋を貼っていただきます。<br>付箋と一致するようにナンバリングの入力をお願いします。
              </dd>
              <dt>●数量</dt>
              <dd>新品の場合のみ入力できます。中古の場合はそれぞれ個体差があるかと思いますので、数量1でご連絡ください</dd>
              <dt>●新品</dt>
              <dd>新品の場合にチェックしてください<br>新品商品の撮影は開封せず外観数枚の撮影となります。</dd>
              <dt>●撮影不要</dt>
              <dd>写真撮影が不要な場合、チェックしてください</dd>
            </dl>
            <p>
              納品リストが完成しましたら、右記の住所までお荷物をお送りください。
              <br>
              <span class="important">
                必ずお荷物の到着より先に納品予定をご連絡ください。納品予定連絡が届いていないと作業を行えません、ご協力のほどよろしくお願いします。
              </span>
            </p>
          </section>
        </div>
        <div class="content-block-lv2">
          <ul class="table-list arrival-box-item mb-20 parent-list-add scroll-shadow" id="product-list-table">
            <li class="list table-header">
              <div class="table-row bottom-line">
                <div class="table-col name">商品名</div>
                <div class="table-col num">ナンバリング</div>
                <div class="table-col quantity">数量</div>
                <div class="table-col new">新品</div>
                <div class="table-col photo">撮影不要</div>
                <div class="table-col measure">採寸不要</div>
                <div class="table-col call">通電不要</div>
                <div class="table-col delete"></div>
              </div>
            </li>
            <?php foreach($products as $product) { ?>
            <li class="list" id="product-list-<?= $product['id']?>">
              <div class="table-row bottom-line">
                <div class="table-col name">
                  <input type="text" id="product-name-<?= $product['id']?>" name="prod_name_<?= $product['id']?>" value="<?= $product['prod_name']?>"/>
                </div>
                <div class="table-col num">
                  <input type="text" id="product-serial-<?= $product['id']?>" name="prod_serial_<?= $product['id']?>" value="<?= $product['prod_serial']?>"/>
                </div>
                <div class="table-col quantity">
                  <input type="number" style="width:70px" id="product-count-<?= $product['id']?>" name="prod_quantity_in_<?= $product['id']?>" value="<?= $product['prod_quantity_in']?>" min="1" required/>
                </div>
                <div class="table-col new">
                  <label for="is-brand-<?= $product['id']?>" class="wrap-checkbox">
                    <?php if($product['is_brand']) {?>
                      <input type="checkbox" id="is-brand-<?= $product['id']?>" name="is_brand_<?= $product['id']?>" checked>
                    <?php } else {?>
                      <input type="checkbox" id="is-brand-<?= $product['id']?>" name="is_brand_<?= $product['id']?>">
                    <?php } ?>
                  </label>
                </div>
                <div class="table-col photo">
                  <label for="is-required-photo-<?= $product['id']?>" class="wrap-checkbox">
                    <?php if($product['req_photo']) {?>
                      <input type="checkbox" id="is-required-photo-<?= $product['id']?>" name="req_photo_<?= $product['id']?>" checked>
                    <?php } else {?>
                      <input type="checkbox" id="is-required-photo-<?= $product['id']?>" name="req_photo_<?= $product['id']?>">
                    <?php } ?>
                  </label>
                </div>
                <div class="table-col measure">
                  <label for="is-required-measure-<?= $product['id']?>" class="wrap-checkbox">
                    <?php if($product['req_measure']) {?>
                      <input type="checkbox" id="is-required-measure-<?= $product['id']?>" name="req_measure_<?= $product['id']?>" checked>
                    <?php } else {?>
                      <input type="checkbox" id="is-required-measure-<?= $product['id']?>" name="req_measure_<?= $product['id']?>">
                    <?php } ?>
                  </label>
                </div>
                <div class="table-col call">
                  <label for="is-required-call-<?= $product['id']?>" class="wrap-checkbox">
                    <?php if($product['req_call']) {?>
                      <input type="checkbox" id="is-required-call-<?= $product['id']?>" name="req_call_<?= $product['id']?>" checked>
                    <?php } else {?>
                      <input type="checkbox" id="is-required-call-<?= $product['id']?>" name="req_call_<?= $product['id']?>">
                    <?php } ?>
                  </label>
                </div>
                <div class="table-col delete">
                  <button type="button" class="btn-delete" onclick="removeProductList(<?= $product['id']?>)"></button>
                </div>
              </div>
            </li>
            <?php } ?>
          </ul>
          <div class="list-add arrival-box" onclick="addNewProductList()">[+] 商品を追加する</div>
        </div>
        <div class="content-block-lv2">
          <div class="notice notice-info mb-20">
            <p>下記の項目についてわかる範囲で良いのでご入力ください。</p>
          </div>
          <div class="form">
            <div class="form-group">
              <div class="form-head">配送会社 </div>
              <div class="form-fill">
                <select name="transfer_id">
                  <?php
                    foreach ($transfers as $transfer) {
                      echo '<option value=' . $transfer['id'] . '>' . $transfer['company_name'] . '</option>';
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="form-head">追跡番号 </div>
              <div class="form-fill">
                <input type="text" name="tracking_number" id="tracking-number">
              </div>
            </div>
            <div class="form-group">
              <div class="form-head">到着予定日 </div>
              <div class="form-fill">
                <input type="date" name="arrival_date" id="arrival_date" value="<?= date('Y-m-d', strtotime('+1 day')) ?>">
              </div>
            </div>
            <div class="form-group">
              <div class="form-head">メモ </div>
              <div class="form-fill">
                <input type="text" name="memo">
              </div>
            </div>
          </div>
        </div>
        <div class="btn-center">
          <input type="hidden" name="data" > 
          <button class="btn btn-primary">送 信</button>
        </div>
      </div>
    </form>
  </div>
</main>

<script>
  function validateNumber(input) {
    return /^\d+$/.test(input);
  }
  
  function checkDate() {
    const arrivalDateInput = document.getElementById("arrival_date");
    const selectedDate = new Date(arrivalDateInput.value);
    const currentDate = new Date();

    if (selectedDate < currentDate) {
      return false;
    } else if (selectedDate.toDateString() === currentDate.toDateString()) {
      return true;
    } else {
      return true;
    }
  }

  const form = document.getElementById('send-schedule-form');
  form.addEventListener('submit', function(event) {
    if (!validateNumber(document.getElementById('tracking-number').value)) {
      event.preventDefault();
      alert('追跡番号は必須入力欄です。追跡番号は数字のみを含みます。 例として「4838-7966-2296」の場合は、「483879662296」と入力する必要があります。');
    }
    
    if (checkDate() == false) {
      event.preventDefault();
      alert('有効な到着予定日を選択してください。');
    }
    return;
  });
  function addNewProductList(){
    let productListHTML = document.getElementById("product-list-table").getElementsByTagName('li');
    const lastScheduledProductId = <?= $products[count($products) - 1]['id']?>;
    let currentId = 0; // initial value
    let lastId = Number(productListHTML[productListHTML.length-1].getAttribute('id').replace('product-list-', ''));

    if (productListHTML.length == 1) {
      currentId = lastScheduledProductId + 1;
    } else {
      if(lastId <= lastScheduledProductId) {
        currentId = lastScheduledProductId + 1;
      } else {
        currentId = lastId + 1
      }
    }

    let productListIds = document.getElementById('product-list-ids').value;
    document.getElementById('product-list-ids').value = productListIds + currentId + ',';

    // appending new list ----------------------------------------
    let li = document.createElement("li");
    li.classList.add("list");
    li.id = "product-list-" + currentId;

    // create the div.table-row element
    let tableRowDiv = document.createElement("div");
    tableRowDiv.classList.add("table-row");
    tableRowDiv.classList.add("bottom-line");

    // create the div.table-col elements for each column
    let nameColDiv = document.createElement("div");
    nameColDiv.classList.add("table-col", "name");
    let nameInput = document.createElement("input");
    nameInput.type = "text";
    nameInput.id = "product-name-" + currentId;
    nameInput.name = "prod_name_" + currentId;
    nameColDiv.appendChild(nameInput);
    tableRowDiv.appendChild(nameColDiv);

    let numColDiv = document.createElement("div");
    numColDiv.classList.add("table-col", "num");
    let numInput = document.createElement("input");
    numInput.type = "text";
    numInput.id = "product-serial-" + currentId;
    numInput.name = "prod_serial_" + currentId;
    numColDiv.appendChild(numInput);
    tableRowDiv.appendChild(numColDiv);

    let quantityColDiv = document.createElement("div");
    quantityColDiv.classList.add("table-col", "quantity");
    let quantityInput = document.createElement("input");
    quantityInput.type = "number";
    quantityInput.style = "width:70px";
    quantityInput.id = "product-count-" + currentId;
    quantityInput.name = "prod_quantity_in_" + currentId;
    quantityInput.min = "1";
    quantityColDiv.appendChild(quantityInput);
    tableRowDiv.appendChild(quantityColDiv);

    let newColDiv = document.createElement("div");
    newColDiv.classList.add("table-col", "new");
    let newLabel = document.createElement("label");
    newLabel.htmlFor = "is-brand-" + currentId;
    newLabel.classList.add("wrap-checkbox");
    let newInput = document.createElement("input");
    newInput.type = "checkbox";
    newInput.id = "is-brand-" + currentId;
    newInput.name = "is_brand_" + currentId;
    newLabel.appendChild(newInput);
    newColDiv.appendChild(newLabel);
    tableRowDiv.appendChild(newColDiv);

    let photoColDiv = document.createElement("div");
    photoColDiv.classList.add("table-col", "photo");
    let photoLabel = document.createElement("label");
    photoLabel.htmlFor = "is-required-photo-" + currentId;
    photoLabel.classList.add("wrap-checkbox");
    let photoInput = document.createElement("input");
    photoInput.type = "checkbox";
    photoInput.id = "is-required-photo-" + currentId;
    photoInput.name = "req_photo_" + currentId;
    photoLabel.appendChild(photoInput);
    photoColDiv.appendChild(photoLabel);
    tableRowDiv.appendChild(photoColDiv);

    let measureColDiv = document.createElement("div");
    measureColDiv.classList.add("table-col", "measure");
    let measureLabel = document.createElement("label");
    measureLabel.htmlFor = "is-required-measure-" + currentId;
    measureLabel.classList.add("wrap-checkbox");
    let measureInput = document.createElement("input");
    measureInput.type = "checkbox";
    measureInput.id = "is-required-measure-" + currentId;
    measureInput.name = "req_measure_" + currentId;
    measureLabel.appendChild(measureInput);
    measureColDiv.appendChild(measureLabel);
    tableRowDiv.appendChild(measureColDiv);

    let callColDiv = document.createElement("div");
    callColDiv.classList.add("table-col", "call");
    let callLabel = document.createElement("label");
    callLabel.htmlFor = "is-required-call-" + currentId;
    callLabel.classList.add("wrap-checkbox");
    let callInput = document.createElement("input");
    callInput.type = "checkbox";
    callInput.id = "is-required-call-" + currentId;
    callInput.name = "req_call_" + currentId;
    callLabel.appendChild(callInput);
    callColDiv.appendChild(callLabel);
    tableRowDiv.appendChild(callColDiv);

    let deleteColDiv = document.createElement("div");
    deleteColDiv.classList.add("table-col", "delete");
    let deleteButton = document.createElement("button");
    deleteButton.type = "button";
    deleteButton.classList.add("btn-delete");
    deleteButton.onclick = function() {
      removeProductList(currentId);
    };
    deleteColDiv.appendChild(deleteButton);
    tableRowDiv.appendChild(deleteColDiv);

    li.appendChild(tableRowDiv);

    // append the li element to the ul#product-list-table
    document.getElementById("product-list-table").appendChild(li);
    // appending new list ----------------------------------------

  }

  function removeProductList(id){
    document.getElementById('product-list-'+id).remove();
    let productListIds = document.getElementById('product-list-ids').value;
    productListIds = productListIds.replace(',' + id + ',', ',');

    if (productListIds == ',') {
      // You removed all products scheduled with CSV. Return back CSV upload page.
      window.location.href = '/csv/create';
    }

    document.getElementById('product-list-ids').value = productListIds;
  }
</script>