<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2017091508748254",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAyHEuQfO2izefRoalXbGcHzC8mSGq9WSFNDkT79Pem+JrvfcLMUu+QJ8tLUz+WboAoeHBR4gG0/jBsGMuYyT5eBEK9TpNz+qQ5pFVdtrosudViesDBRsp07BJU8NJzSj+lpEvCdQ3OxmelavL94JEj9gco/d/DZRnRRXShY/RCV3SQj/psaZEUI2rxwL6WeEf3V7hisIOnls086fLnEalGGNb096epyGyClmqAzTEj5FkCUnVOT6DxiDaNJ/X+G4IJzj/JaItJQTtu98Mw64ODAHRzsbtykvPv0tjzsCuSpf5uAq3y75BGkBTYfuS2Oi6dc9SjEscrtA50Nf4E5qdoQIDAQABAoIBACH2C0Bhaqxr4DCy35HgZfNi7pGDgtPRFECk6xvXagA/fMHS+bKAgtuwHJdwVCgfu7ux5G2aPo3rt+WK6HEj8qDFQnYKSuTPeX2XYkOhE4w8ZeHYT8qtr4iOdd4bWIXKTFh2gOHJcxIwZQ427XgiOjulAjVF2eETI+wwplq641ASqIgajKT3XhzCNXcOgtXXCEp3dTLvj8/HSuzyTP0pzzJljSX0qOWe+lUzE2bE+X47epx1rxML/UF8MUz7Y6jCcEMhTgG5uQ800iJB5sU2UIsk2B6oPuXZuKtt6EkjCN+yGFOhWCt6Ba7kvRKPjIWO7plMjUWgKbpQ2T0V89fNpYECgYEA8ExB3gdTp4vN52ytgG6m4d2+cnTakiAqtN6u/EjlpXDmoDforwf5AY0FgAJC6EDFpiVA64zRli6BVtJjV4/Hz/y0X8IzrD2cbROqjriSYERvqKnw98ck9XUpVrlpEQyokx4hjLGT41XdpqRNcfmj5Y0laTpc5gCvYbRcsBsLg18CgYEA1Yo1oupqJkOikxQn4F24cN5vAyJWFfXpD3obn8DHQuCNti3+clXwnw5bV+LfaST/jKWwHdpHqiVsLNrvZEdPU1Wj82wbQf04hI0vHrWYmFnj+djWwU6SmT+nITWK13YezQRLBHGJ4OGnv2KlS+mzxH0QTrX0f9hOIk2PjEPGfv8CgYAuLGkHsd64Nhv1mSNpp1l30zUSJzQMmhO6t4NmRNejx6L5LGUQpPaK/r8MzuJuYGvaNhRYbrGjKwJ9XWXrYFxjscozEEz/jsMtDndaf0rZJq1R+n2sDt8iL0YnPO9ccFNAGa0WrNSe/VPe/nlHKlH8/PcwVh+drooEuzSIPloi/wKBgHhKUQijMIS5mP1tX0E+ykWap8KGNyRL0KwNRz5o5FbCFFJJ+ooB63hOKBqMDPo4A1UBiQJoEfLA/f0On8hHe2IgXikj/v7fXFUfCyordfhsusXl5qQiVObLOqS0erABNDydbHzmUJtDwrFHKoJm9gN7yBHu4fqaqPkd4/1JuKmVAoGBAOyo5T0mEW5/855PwQU9HAN4WPOoaZhYMIt+CoAtes9F2EGPO6TUb7CLmWm3tJUTFagLyV+vEpyAVejTSlQ7LHVprC8h3Xn5Ais4sUUWBYnUuCyANQKaPKqwHj3RuhNy1BnzXCCepJnONCNASBqaxTOz794lVFZAx1zwjhklJ1I+",
		
		//异步通知地址
		'notify_url' => "http://".$_SERVER['HTTP_HOST']."/App/Alipay/web/notify_url.php",
		
		//同步跳转
		'return_url' => "http://".$_SERVER['HTTP_HOST'],

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		// 'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjWPZEKLg9wmrTz2hrarT4uAKbtCANhKuqg1LhMdrxz1tWfMTzyy3kMrFPvViQVUJ4zzwrBXFnJwVMLRDXyt+iMcMqCWCXUOT2dpltAeHhx94mmog4I1/NgIeanTeXPQsZoVUYZ/cSxC4MEh9JegSnJJwuPNE+pJaOxylXC9Sg804DGRh71yOquvyTPuYCn2lm50ZafW3hEO0pJrqanK47isteZNx9uNxY7lGKW67WxRJTvfUyQoaTUxWB4PFZu06ig4TRer1XveSD8mmBYd7uemK0lfYYFgQRlD4ewQuSB1oZqUszdgA6P73Wn1n4fTuRWtGi6iQnx1jaT4Fbn3KQwIDAQAB",
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjWPZEKLg9wmrTz2hrarT4uAKbtCANhKuqg1LhMdrxz1tWfMTzyy3kMrFPvViQVUJ4zzwrBXFnJwVMLRDXyt+iMcMqCWCXUOT2dpltAeHhx94mmog4I1/NgIeanTeXPQsZoVUYZ/cSxC4MEh9JegSnJJwuPNE+pJaOxylXC9Sg804DGRh71yOquvyTPuYCn2lm50ZafW3hEO0pJrqanK47isteZNx9uNxY7lGKW67WxRJTvfUyQoaTUxWB4PFZu06ig4TRer1XveSD8mmBYd7uemK0lfYYFgQRlD4ewQuSB1oZqUszdgA6P73Wn1n4fTuRWtGi6iQnx1jaT4Fbn3KQwIDAQAB",
		
	
);