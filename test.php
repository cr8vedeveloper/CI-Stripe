<?php

print_r(array_merge([''], range(0, 24)));
exit;

  // ------------------------------------------------ 初期設定
  $serviceSecret = "SP383890_3o5Mcb43yi2iWz1d";		// サービスシークレット（１）
  $licenseKey = "SL383890_e35oj0E9H0G4Sr9P";				// ライセンスキー（２）
  $shop_url = "k-digital";				// ストアアカウント

  // ------------------------------------------------ 受注情報を取得
  $authkey = "ESA " . base64_encode($serviceSecret . ':' . $licenseKey);
  $post_xml = "<?xml version='1.0' encoding='UTF-8'?>
  <SOAP-ENV:Envelope xmlns:SOAP-ENV='http://schemas.xmlsoap.org/soap/envelope/' xmlns:ns1='http://orderapi.rms.rakuten.co.jp/rms/mall/order/api/ws'>
  <SOAP-ENV:Body>
  <ns1:getOrder>
  <arg0>
    <authKey>{$authkey}</authKey>
    <shopUrl>{$shop_url}</shopUrl>
    <userName>?</userName>
  </arg0>
  <arg1>
    <isOrderNumberOnlyFlg>false</isOrderNumberOnlyFlg>
    <orderSearchModel>
      <dateType>1</dateType>
      <startDate>2021-01-26</startDate>
      <endDate>2021-02-08</endDate>
    </orderSearchModel>
  </arg1>
  </ns1:getOrder>
  </SOAP-ENV:Body>
  </SOAP-ENV:Envelope>";
  $header = array(
    "Content-Type: text/xml;charset=UTF-8",
  );

  $url = "https://api.rms.rakuten.co.jp/es/1.0/order/ws";
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_xml);
  $xml = curl_exec($ch);
  curl_close($ch);

  print_r($xml);

  $clean_xml = str_ireplace(['S:', 'ns2:'], '', $xml);
  $data = simplexml_load_string($clean_xml);
  $data = json_decode(json_encode($data), true);

?>