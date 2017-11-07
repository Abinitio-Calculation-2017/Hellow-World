<!--
  CSVファイル（新共用システム設備一覧表.csvという名称）に記載されている情報を検索して表として表示するwebページ
  Excelではcsv形式にして保存してください。
  CSVファイル名は"新共用システム設備一覧表.csv"としてください。CSVのファイルはrscフォルダのdataに入れてください。
  "Ⅶ"ではなく"7"としてください。
  "設備名"という欄は必ず必要です。設備名と書かれている行が表の一番上のタイトルになります。
  "設備名"をクリックした場合は、./rcs/contents/RCS1No1.htmlなどとしてリンクします。
  "検索キー"という欄を作ると、そこは検索だけに使われ表示されません。
  "検索キー"の中にはRCS-1やRCS-2という記述をして頂けると"施設名"で検索がし易くなりますのでお願い致します。
  "RCS"と"No."のどちらかでも欄が存在しない場合は、"リンクキー"にRCS1No01などと記述してください。
  もし、タグがお分かりでしたら、設備名のところにタグを記述してもリンクが動作します。
  日本語は改行されますが、英数字だけでは改行されません。
  
  References
  [1] 名古屋大学 設備・機器共用システム(Nagoya University Equipment Sharing System); https://es.tech.nagoya-u.ac.jp/public/php/mkgKikiSearchTop.php
  [2] 名古屋大学 工学研究科 共用化委員会; https://nuess.engg.nagoya-u.ac.jp/
-->
<!DOCTYPE html>
<html lang="ja">
  <head>
    <title>名古屋工業大学 新共用システム</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <style type="text/css">
      /*全体的な設定*/
      body {background-color:#fff8e0; text-align:center; font-size:10.5pt;}
      /*一番上のタイトル部分*/
      header {background-color:#ffffff; text-align:center;}
      .header-logo {display: inline-block;}
      .header-title {display: inline-block;}
      /*検索＆予約や装置分類表の部分*/
      nav {text-align:center; background-color:rgb(187,255,152);}
      ul {list-style:none;}
      li {display: inline-block;}
      a.waku {color: #000000; background-color: #58ff8e; display: block; width: 150px;
        padding: 5px 10px; text-decoration: none;}
      a.waku:hover {background-color:#dd9dbf;}
      p {text-align:center;}
      /*施設名やフリーワード、検索結果の表の部分*/
      table {border-collapse: collapse; margin-left:auto; margin-right:auto;}
      .page-search {border-collapse: collapse; border-style: solid; border-width: 1px;
        border-color: #888888; background-color:#ffffff;}
      span {font-size:10.5pt;}
      select {width:700px;}
      th,td {font-size:10.5pt;}
      /*装置のテーブル*/
      table.souchi {background-color:#ffffff;}
      th.souchi {background-color:#dddddd;}
      /*検索結果でのリンク*/
      a {text-decoration: none;}
    </style>
  </head>
  <!--検索入力欄-->
  <body>
    <header>
      <div class="header-logo"></div>
        <img alt="名古屋工業大学ロゴ" src="./rcs/img/nit-logo.gif"></img>
      <div class="header-title">
        <img alt="名古屋工業大学 新共用システム" src="./rcs/img/title-logo.png"></img>
      </div>
    </header>
    <nav>
      <ul>
        <li>
          <a class="waku" href="./nit-search.php">検索＆予約</a>
        </li>
        <li>
          <a class="waku" href="./rcs/contents/classify.html">RCS（新共用システム）<br>装置分類表</a>
        </li>
        <li>
          <a class="waku" href="./rcs/contents/attitude.html">実験を始める前の心構え</a>
        </li>
      </ul>
    </nav>
    <p>
      検索条件を入力して、AND検索またはOR検索ボタンをクリックしてください<br>
      AND検索は条件の全てに、OR検索は条件のいずれかに、マッチするデータを一覧表示します
    </p>
    <form method="post" action="nit-search.php">
      <table class="page-search">
        <tbody>
          <tr>
            <th class="page-search">施設名</th>
            <td class="page-search" colspan="1">
              <select name="institute">
                <!--特殊文字の処理を減らすため、実際の検索では英数字で検索-->
                <option value="-" elected="">-</option>
                <option value="RCS-1">RCS-Ⅰ</option>
                <option value="RCS-2">RCS-Ⅱ</option>
                <option value="RCS-3">RCS-Ⅲ</option>
                <option value="RCS-4">RCS-Ⅳ</option>
                <option value="RCS-5">RCS-Ⅴ</option>
                <option value="RCS-6">RCS-Ⅵ</option>
                <option value="RCS-7">RCS-Ⅶ</option>
              </select>
            </td>
          </tr>
          <tr>
            <th class="page-search">フリーワード</th>
            <td class="page-search" colspan="1">
              <input name="key" type="text" size="113" value="<?php if(isset($_POST['key'])){print(htmlspecialchars($_POST['key'], ENT_QUOTES, "UTF-8"));} ?>"></input>
              <br></br>
              <span>設備の全属性から検索します。全角・半角を区別しますが、大文字・小文字を区別しません</span>
            </td>
          </tr>
        <tbody>
      </table>
      <br>
      <input name="searchType" type="submit" value="AND検索">
      <input name="searchType" type="submit" value="OR検索">
    </form>
    
<!--検索での表の結果表示部分-->
<?php
if (isset($_POST['institute']) && isset($_POST['key'])){
  if ($_POST['institute']!="-" && $_POST['key']!=""){
    $keywords = htmlspecialchars($_POST['institute'], ENT_QUOTES, "UTF-8").",".htmlspecialchars($_POST['key'], ENT_QUOTES, "UTF-8");
  }elseif ($_POST['institute']!="-"){
    $keywords = htmlspecialchars($_POST['institute'], ENT_QUOTES, "UTF-8");
  }else{
    $keywords = htmlspecialchars($_POST['key'], ENT_QUOTES, "UTF-8");
  }
  if ($keywords!=""){
    $keyword1 = str_replace(array("　", " " , "、", "，", "?", "http", "\"", "\”"), ",", $keywords); 
    $keyword2 = preg_replace('|,+|', ',', $keyword1);
    $keyword3 = rtrim($keyword2, ",");
    $keyword  = explode(",", $keyword3);
    
    if (sizeof($keyword)<=15 && mb_strlen($keywords)<=150 ){
      
      // csvファイルの読み込み
      $read_data=file("./rcs/data/新共用システム設備一覧表.csv");
      
      // csvファイルの読み込み、php 5.1 or later、テスト中
      //$filepath = "./rcs/data/新共用システム設備（料金）一覧表171002.csv";
      //$read_data = new SplFileObject($filepath);
      //$read_data -> setFlags(SplFileObject::READ_CSV);
      
      // utf-8に変換と表のタイトル
      $data_convert = str_replace(array(","), "</td><td>", $read_data);
      $data = str_replace(array("\r\n","\r","\n"), "", $data_convert); // 今後の検索のために改行コード無しに変換
      foreach ($data as $lineno => $line) {
        $data[$lineno] = mb_convert_encoding($line, "UTF-8", "auto");
      }
      
      // ANDとOR検索
      if (isset($_POST["searchType"])) {
        $aow = htmlspecialchars($_POST["searchType"], ENT_QUOTES, "UTF-8");
        switch ($aow) {
          case "AND検索": 
            $n=1;
            for($i=1;$i<sizeof($data);$i++){
              $lines=strip_tags($data[$i]);
              $found=0;
              for($j=0;$j<sizeof($keyword);$j++){
                if(mb_eregi($keyword[$j], $lines)){
                  $found++;
                }
              }
              if($found==sizeof($keyword)){
                $showdata[$n]=$i;
                $n++;
              }
            }
            echo "ANDの検索結果  ";
            echo "<font size=\"5\" color=rgb(255,0,0)>", $n-1, " 件 </font>";
            break;
          
          case "OR検索" : 
            $n=1;
            for($i=1;$i<sizeof($data);$i++){
              $lines=strip_tags($data[$i]);
              $found=0;
              for($j=0;$j<sizeof($keyword);$j++){
                if(mb_eregi($keyword[$j], $lines)){
                  $found=1;
                }
              }
              if($found==1){
                $showdata[$n]=$i;
                $n++;
              }
            }
            echo "ORの検索結果  ";
            echo "<font size=\"5\" color=rgb(255,0,0)>", $n-1, " 件 </font>";
            break;
            
          default:  echo "エラー"; exit;
        }
        
        // ANDとORの結果の表示（ANDとORで共通）
        echo "※設備名をクリックすると詳細情報が表示されます<br></br>";
        
        // タイトルの部分
        foreach ($data as $lineno => $line) {
          if(mb_eregi("設備名", $data[$lineno])){
            echo "<table border=\"1\" width=\"100%\" style=\"table-layout: fixed;\">";
            $data[$lineno] = str_replace(array("</td><td>"), "</th><th>", $data[$lineno]); 
            $list = explode("</th><th>", $data[$lineno]);
            
            // リンクを貼るためにRCS, No, 設備名, 検索キーの場所を探して、$line_rcsno, $line_no, $line_linkno, $line_keynoに入れる
            //初期化
            $line_rcsno      = "999";
            $line_no         = "999";
            $line_keyno      = "999";
            $line_link_keyno = "999";
            foreach ($list as $lineno_tag => $line_tag) {
              if($line_tag == "RCS"){
                $line_rcsno  = $lineno_tag;
              }
              if($line_tag == "No."){
                $line_no     = $lineno_tag;
              }
              if($line_tag == "設備名"){
                $line_linkno = $lineno_tag;
              }
              if($line_tag == "検索キー"){
                $line_keyno  = $lineno_tag;
              }
              if($line_tag == "リンクキー"){
                $line_link_keyno  = $lineno_tag;
              }
            }
            
            // タイトル表示
            echo "<tr bgcolor=rgb(187,255,152)>";
            foreach ($list as $lineno_title => $line_title) {
              if($lineno_title == $line_keyno or $lineno_title == $line_link_keyno){
                //検索キーの欄で、表示しないことにしている。
              }else{
                echo "<th>$line_title</th>";
              }
            }
            echo "</tr>";
          }
        }
        
        // 主要な表の部分
        //初期化
        $rcsno = "9999";
        $no    = "100";
        $link  = "RCSXNoYZ";
        for($i=1;$i<$n;$i++){
          $j=$showdata[$i];
          $list = explode("</td><td>", $data[$j]);
          if($line_rcsno != "999"){
            $rcsno = $list[$line_rcsno];
          }
          if($line_no != "999"){
            $no    = $list[$line_no];
            if (intval($no) <= 9){
              $no = "0".$list[$line_no];
            }
          }
          if($line_link_keyno != "999"){
            $link = $list[$line_link_keyno];
          }
          echo "<tr width=1100, bgcolor=rgb(242,255,226)>";
          foreach ($list as $lineno_main => $line_main) {
            if($lineno_main == $line_linkno){
              // RCSとNo.でリンク。
              if($rcsno != "9999" and $no != "100"){
                $link = "RCS".$rcsno."No".$no;
              }
              if( $link != "RCSXNoYZ" ){
                echo "<td><a href=\"./rcs/contents/{$link}.html\" target=\"_blank\">$line_main</a></td>";
              }else{
                echo "<td>$line_main</td>";
              }
              // 設備名でリンク。文字コードの種類に注意。同じ設備名では不良動作するため廃止
              //$line_main_correct = str_replace(array("/"), "", $line_main);
              //echo "<td><a href=\"./rcs/contents/{$line_main_correct}.html\" target=\"_blank\">$line_main</a></td>";
            }elseif($lineno_main == $line_keyno or $lineno_main == $line_link_keyno){
              //検索キーやリンクの欄で表示しないことにしている。
            }else{
              echo "<td>$line_main</td>";
            }
          }
          echo "</tr>";
        }
      }
    }elseif(sizeof($keyword)>15 && mb_strlen($keywords)>150){
      echo "お手数をおかけしますが、サーバーの負担軽減のために<br>ワード数は15個以内、フリーワードは150文字以内に制限させて頂いております<br></br>";
    }elseif(sizeof($keyword)>15){
      echo "お手数をおかけしますが、サーバーの負担軽減のために<br>ワード数は15個以内に制限させて頂いております<br></br>";
    }elseif(mb_strlen($keywords)>150){
      echo "お手数をおかけしますが、サーバーの負担軽減のために<br>フリーワードは150文字以内に制限させて頂いております<br></br>";
    }
  }
}
?>
    
    </table>
  </body>
</html>
