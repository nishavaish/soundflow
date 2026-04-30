<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class S3Uploader {

    private $bucket = AWS_BUCKET_NAME;
    private $region = AWS_ACCESS_REGION;
    private $accessKey = AWS_ACCESS_KEY_ID;
    private $secretKey = AWS_ACCESS_KEY_SECRET;

    private function sign($key, $msg) {
        return hash_hmac('sha256', $msg, $key, true);
    }

    private function getSigningKey($date) {
        $kSecret = "AWS4" . $this->secretKey;
        $kDate = $this->sign($kSecret, $date);
        $kRegion = $this->sign($kDate, $this->region);
        $kService = $this->sign($kRegion, 's3');
        return $this->sign($kService, 'aws4_request');
    }

    private function getHost() {
        return "{$this->bucket}.s3.{$this->region}.amazonaws.com";
    }

    // 🔹 Artwork Upload URL
    public function getPutUrl($fileName) {

        $key = "uploads/artwork/" . time() . "_" . $fileName;

        $host = $this->getHost();
        $amzdate = gmdate('Ymd\THis\Z');
        $date = gmdate('Ymd');

        $scope = "$date/{$this->region}/s3/aws4_request";

        $query = [
            'X-Amz-Algorithm' => 'AWS4-HMAC-SHA256',
            'X-Amz-Credential' => $this->accessKey . '/' . $scope,
            'X-Amz-Date' => $amzdate,
            'X-Amz-Expires' => 300,
           'X-Amz-SignedHeaders' => 'host;x-amz-acl'
        ];

        $qs = http_build_query($query);

        //$canonical = "PUT\n/$key\n$qs\nhost:$host\n\nhost\nUNSIGNED-PAYLOAD";
        $canonical = "PUT\n/$key\n$qs\nhost:$host\nx-amz-acl:private\n\nhost;x-amz-acl\nUNSIGNED-PAYLOAD";

        $string = "AWS4-HMAC-SHA256\n$amzdate\n$scope\n" . hash('sha256', $canonical);

        $signature = hash_hmac('sha256', $string, $this->getSigningKey($date));

        return [
            'url' => "https://$host/$key?$qs&X-Amz-Signature=$signature",
            'file_url' => "https://$host/$key"
        ];
    }

   
   // 🔹 Invoices Upload URL
    public function getPutInvoiceUrl($fileName) {
		
        $key = "uploads/invoices/" . time() . "_" . $fileName;

        $host = $this->getHost();
        $amzdate = gmdate('Ymd\THis\Z');
        $date = gmdate('Ymd');

        $scope = "$date/{$this->region}/s3/aws4_request";

        $query = [
            'X-Amz-Algorithm' => 'AWS4-HMAC-SHA256',
            'X-Amz-Credential' => $this->accessKey . '/' . $scope,
            'X-Amz-Date' => $amzdate,
            'X-Amz-Expires' => 300,
           'X-Amz-SignedHeaders' => 'host;x-amz-acl'
        ];

        $qs = http_build_query($query);

        //$canonical = "PUT\n/$key\n$qs\nhost:$host\n\nhost\nUNSIGNED-PAYLOAD";
        $canonical = "PUT\n/$key\n$qs\nhost:$host\nx-amz-acl:private\n\nhost;x-amz-acl\nUNSIGNED-PAYLOAD";

        $string = "AWS4-HMAC-SHA256\n$amzdate\n$scope\n" . hash('sha256', $canonical);

        $signature = hash_hmac('sha256', $string, $this->getSigningKey($date));

        return [
            'url' => "https://$host/$key?$qs&X-Amz-Signature=$signature",
            'file_url' => "https://$host/$key"
        ];
    }

   
   
   
   // 🔹 Initiate multipart (SIGNED)
   public function initiateMultipart($fileName) {

    $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);

    $key = "uploads/audio/" . time() . "_" . $fileName;

    $host = "{$this->bucket}.s3.{$this->region}.amazonaws.com";

    $amzdate = gmdate('Ymd\THis\Z');
    $datestamp = gmdate('Ymd');

    $canonical_uri = "/$key";
    $canonical_querystring = "uploads=";

    $canonical_headers = "host:$host\nx-amz-date:$amzdate\n";
    $signed_headers = "host;x-amz-date";
	

    $payload_hash = hash('sha256', '');

    $canonical_request = "POST\n$canonical_uri\n$canonical_querystring\n$canonical_headers\n$signed_headers\n$payload_hash";

    $algorithm = "AWS4-HMAC-SHA256";
    $credential_scope = "$datestamp/{$this->region}/s3/aws4_request";

    $string_to_sign = "$algorithm\n$amzdate\n$credential_scope\n" . hash('sha256', $canonical_request);

    $signingKey = $this->getSigningKey($datestamp);

    $signature = hash_hmac('sha256', $string_to_sign, $signingKey);

    $authorization = "$algorithm Credential={$this->accessKey}/$credential_scope, SignedHeaders=$signed_headers, Signature=$signature";

    $url = "https://$host/$key?uploads";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "x-amz-date: $amzdate",
        "Authorization: $authorization",
        "x-amz-content-sha256: $payload_hash"
		
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    // ✅ SAFE parsing
    preg_match('/<UploadId>(.*?)<\/UploadId>/', $response, $matches);

    if (!isset($matches[1])) {
        return [
            'error' => 'Failed to initiate upload',
            'raw' => $response
        ];
    }
	
	

    return [
        'key' => $key,
        'uploadId' => $matches[1]
    ];
}

    
    // 🔹 Initiate multipart (SIGNED) -- for Assets Library
   public function initiateMultipartAssets($fileName) {

    $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);

    $key = "uploads/users-assets/" . time() . "_" . $fileName;

    $host = "{$this->bucket}.s3.{$this->region}.amazonaws.com";

    $amzdate = gmdate('Ymd\THis\Z');
    $datestamp = gmdate('Ymd');

    $canonical_uri = "/$key";
    $canonical_querystring = "uploads=";

    $canonical_headers = "host:$host\nx-amz-date:$amzdate\n";
    $signed_headers = "host;x-amz-date";
	

    $payload_hash = hash('sha256', '');

    $canonical_request = "POST\n$canonical_uri\n$canonical_querystring\n$canonical_headers\n$signed_headers\n$payload_hash";

    $algorithm = "AWS4-HMAC-SHA256";
    $credential_scope = "$datestamp/{$this->region}/s3/aws4_request";

    $string_to_sign = "$algorithm\n$amzdate\n$credential_scope\n" . hash('sha256', $canonical_request);

    $signingKey = $this->getSigningKey($datestamp);

    $signature = hash_hmac('sha256', $string_to_sign, $signingKey);

    $authorization = "$algorithm Credential={$this->accessKey}/$credential_scope, SignedHeaders=$signed_headers, Signature=$signature";

    $url = "https://$host/$key?uploads";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "x-amz-date: $amzdate",
        "Authorization: $authorization",
        "x-amz-content-sha256: $payload_hash"
		
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    // ✅ SAFE parsing
    preg_match('/<UploadId>(.*?)<\/UploadId>/', $response, $matches);

    if (!isset($matches[1])) {
        return [
            'error' => 'Failed to initiate upload',
            'raw' => $response
        ];
    }
	
	

    return [
        'key' => $key,
        'uploadId' => $matches[1]
    ];
}

    // 🔹 Chunk signed URL
    public function getChunkUrl($key, $uploadId, $part) {

        $host = $this->getHost();

        $amzdate = gmdate('Ymd\THis\Z');
        $date = gmdate('Ymd');
        $scope = "$date/{$this->region}/s3/aws4_request";

        $query = [
            'X-Amz-Algorithm' => 'AWS4-HMAC-SHA256',
            'X-Amz-Credential' => $this->accessKey . '/' . $scope,
            'X-Amz-Date' => $amzdate,
            'X-Amz-Expires' => 300,
            'X-Amz-SignedHeaders' => 'host',
            'partNumber' => $part,
            'uploadId' => $uploadId
        ];

        $qs = http_build_query($query);

        $canonical = "PUT\n/$key\n$qs\nhost:$host\n\nhost\nUNSIGNED-PAYLOAD";

        $string = "AWS4-HMAC-SHA256\n$amzdate\n$scope\n" . hash('sha256', $canonical);

        $signature = hash_hmac('sha256', $string, $this->getSigningKey($date));

        return ['url' => "https://$host/$key?$qs&X-Amz-Signature=$signature"];
    }
	
	

    // 🔹 Complete multipart (SIGNED)
    public function completeMultipart__old($key, $uploadId, $parts) {

        $xml = "<CompleteMultipartUpload>";
        foreach ($parts as $p) {
            $xml .= "<Part><PartNumber>{$p['PartNumber']}</PartNumber><ETag>{$p['ETag']}</ETag></Part>";
        }
        $xml .= "</CompleteMultipartUpload>";

        $host = $this->getHost();

        $amzdate = gmdate('Ymd\THis\Z');
        $date = gmdate('Ymd');
        $scope = "$date/{$this->region}/s3/aws4_request";

        $canonical = "POST\n/$key\nuploadId=$uploadId\nhost:$host\n\nhost\n" . hash('sha256', $xml);

        $string = "AWS4-HMAC-SHA256\n$amzdate\n$scope\n" . hash('sha256', $canonical);

        $signature = hash_hmac('sha256', $string, $this->getSigningKey($date));

        $url = "https://$host/$key?uploadId=$uploadId";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: AWS4-HMAC-SHA256 Credential={$this->accessKey}/$scope, SignedHeaders=host, Signature=$signature",
            "x-amz-date: $amzdate",
            "x-amz-content-sha256: " . hash('sha256', $xml)
        ]);

        curl_exec($ch);
        curl_close($ch);

        return "https://$host/$key";
    }
	
	public function completeMultipart__old__2($key, $uploadId, $parts) {

    if (!is_array($parts) || empty($parts)) {
        return ['status'=>'error','message'=>'Invalid parts'];
    }

    $xml = "<CompleteMultipartUpload>";

    foreach ($parts as $p) {
        $xml .= "<Part><PartNumber>{$p['PartNumber']}</PartNumber><ETag>{$p['ETag']}</ETag></Part>";
    }

    $xml .= "</CompleteMultipartUpload>";

    $url = "https://{$this->bucket}.s3.{$this->region}.amazonaws.com/$key?uploadId=$uploadId";

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/xml"
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode != 200) {
        return [
            'status'=>'error',
            'response'=>$response
        ];
    }

    $fileUrl = "https://{$this->bucket}.s3.{$this->region}.amazonaws.com/{$key}";

    return [
        'status'=>'success',
        'file_url'=>$fileUrl
    ];
}


	public function completeMultipart($key, $uploadId, $parts) {

		usort($parts, fn($a,$b) => $a['PartNumber'] - $b['PartNumber']);

		$xml = "<CompleteMultipartUpload>";
		foreach ($parts as $p) {
			$xml .= "<Part>
						<PartNumber>{$p['PartNumber']}</PartNumber>
						<ETag>{$p['ETag']}</ETag>
					 </Part>";
		}
		$xml .= "</CompleteMultipartUpload>";

		$host = "{$this->bucket}.s3.{$this->region}.amazonaws.com";

		$amzdate = gmdate('Ymd\THis\Z');
		$date = gmdate('Ymd');
		$scope = "$date/{$this->region}/s3/aws4_request";

		//$payload_hash = hash('sha256', $xml);
	   // $canonical_request = "POST\n/$key\nuploadId=$uploadId\nhost:$host\n\nhost\n$payload_hash";
		
		
		$canonical_headers = "host:$host\nx-amz-date:$amzdate\n";
		$signed_headers = "host;x-amz-date";

		$payload_hash = hash('sha256', $xml);

		$canonical_request = "POST\n/$key\nuploadId=$uploadId\n$canonical_headers\n$signed_headers\n$payload_hash";



		$string_to_sign = "AWS4-HMAC-SHA256\n$amzdate\n$scope\n" . hash('sha256', $canonical_request);

		$signature = hash_hmac('sha256', $string_to_sign, $this->getSigningKey($date));

	   // $authorization = "AWS4-HMAC-SHA256 Credential={$this->accessKey}/$scope, SignedHeaders=host, Signature=$signature";
		$authorization = "AWS4-HMAC-SHA256 Credential={$this->accessKey}/$scope, SignedHeaders=$signed_headers, Signature=$signature";
	   
		   
	   
		$url = "https://$host/$key?uploadId=$uploadId";

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: $authorization",
			"x-amz-date: $amzdate",
			"x-amz-content-sha256: $payload_hash",
			"Content-Type: application/xml"
		]);

		$response = curl_exec($ch);
		
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		curl_close($ch);

	   
		
		return [
			'status' => ($httpCode == 200 ? 'success' : 'error'),
			'http' => $httpCode,
			'file_url' => ($httpCode == 200 ? "https://$host/$key" : ""),
			'raw' => $response
		];
	}
		
	
	public function getSignedChunkUrl($key, $uploadId, $partNumber) {

    $host = "{$this->bucket}.s3.{$this->region}.amazonaws.com";

    $expires = 300;

    $amzdate = gmdate('Ymd\THis\Z');
    $datestamp = gmdate('Ymd');

    $credential_scope = "$datestamp/{$this->region}/s3/aws4_request";

    // IMPORTANT: RAW QUERY (no http_build_query)
    $query = "X-Amz-Algorithm=AWS4-HMAC-SHA256";
    $query .= "&X-Amz-Credential=" . rawurlencode($this->accessKey . '/' . $credential_scope);
    $query .= "&X-Amz-Date=$amzdate";
    $query .= "&X-Amz-Expires=$expires";
    $query .= "&X-Amz-SignedHeaders=host";
    $query .= "&partNumber=$partNumber";
    $query .= "&uploadId=" . rawurlencode($uploadId);

    $canonical_request = "PUT\n/$key\n$query\nhost:$host\n\nhost\nUNSIGNED-PAYLOAD";

    $string_to_sign = "AWS4-HMAC-SHA256\n$amzdate\n$credential_scope\n" . hash('sha256', $canonical_request);

    $signingKey = $this->getSignatureKey($datestamp);

    $signature = hash_hmac('sha256', $string_to_sign, $signingKey);

    $url = "https://$host/$key?$query&X-Amz-Signature=$signature";

    return ['url' => $url];
}



	public function getSignedGetUrl($key, $expires = 300) {

		$host = "{$this->bucket}.s3.{$this->region}.amazonaws.com";

		$amzdate = gmdate('Ymd\THis\Z');
		$datestamp = gmdate('Ymd');

		$credential_scope = "$datestamp/{$this->region}/s3/aws4_request";

		$query = [
			'X-Amz-Algorithm' => 'AWS4-HMAC-SHA256',
			'X-Amz-Credential' => $this->accessKey . '/' . $credential_scope,
			'X-Amz-Date' => $amzdate,
			'X-Amz-Expires' => $expires,
			'X-Amz-SignedHeaders' => 'host'
		];

		$canonical_querystring = http_build_query($query);

		$canonical_request = "GET\n/$key\n$canonical_querystring\nhost:$host\n\nhost\nUNSIGNED-PAYLOAD";

		$string_to_sign = "AWS4-HMAC-SHA256\n$amzdate\n$credential_scope\n" . hash('sha256', $canonical_request);

		$signingKey = $this->getSigningKey($datestamp);

		$signature = hash_hmac('sha256', $string_to_sign, $signingKey);

		return "https://$host/$key?$canonical_querystring&X-Amz-Signature=$signature";
	}


	public function getSignedGetUrlDownload($key, $expires = 300, $download = false) {

		$host = "{$this->bucket}.s3.{$this->region}.amazonaws.com";

		$amzdate = gmdate('Ymd\THis\Z');
		$datestamp = gmdate('Ymd');

		$credential_scope = "$datestamp/{$this->region}/s3/aws4_request";

		// ✅ Base query
		$query = [
			'X-Amz-Algorithm' => 'AWS4-HMAC-SHA256',
			'X-Amz-Credential' => $this->accessKey . '/' . $credential_scope,
			'X-Amz-Date' => $amzdate,
			'X-Amz-Expires' => $expires,
			'X-Amz-SignedHeaders' => 'host'
		];

		// ✅ ADD THIS FOR DOWNLOAD
		if ($download) {
			$filename = basename($key);

			//$query['response-content-disposition'] = "attachment; filename=\"{$filename}\"";
			$query['response-content-disposition'] = "attachment;filename={$filename}";
		}

		// IMPORTANT: sort query (AWS requires lexicographical order)
		ksort($query);

		//$canonical_querystring = http_build_query($query);
		$canonical_querystring = $this->buildQueryString($query);

		$canonical_request = "GET\n/$key\n$canonical_querystring\nhost:$host\n\nhost\nUNSIGNED-PAYLOAD";

		$string_to_sign = "AWS4-HMAC-SHA256\n$amzdate\n$credential_scope\n" . hash('sha256', $canonical_request);

		$signingKey = $this->getSigningKey($datestamp);

		$signature = hash_hmac('sha256', $string_to_sign, $signingKey);

		return "https://$host/$key?$canonical_querystring&X-Amz-Signature=$signature";
	}
	
	
	private function buildQueryString($params) {
		ksort($params);

		$encoded = [];
		foreach ($params as $key => $value) {
			$encoded[] = rawurlencode($key) . '=' . rawurlencode($value);
		}

		return implode('&', $encoded);
	}

	public function deleteObject($filePath){
		try {
			
			if (empty($filePath)) {
				throw new Exception('Empty file path');
			}

			// ✅ Extract key from full URL OR accept raw key
			if (filter_var($filePath, FILTER_VALIDATE_URL)) {
				$parsed = parse_url($filePath);

				if (empty($parsed['path'])) {
					throw new Exception('Invalid file URL');
				}

				$key = ltrim($parsed['path'], '/');
			} else {
				$key = ltrim($filePath, '/');
			}

			$host = "{$this->bucket}.s3.{$this->region}.amazonaws.com";

			$amzdate = gmdate('Ymd\THis\Z');
			$datestamp = gmdate('Ymd');

			$canonical_uri = "/$key";
			$canonical_querystring = "";

			$canonical_headers = "host:$host\nx-amz-date:$amzdate\n";
			$signed_headers = "host;x-amz-date";

			$payload_hash = hash('sha256', '');

			$canonical_request = "DELETE\n$canonical_uri\n$canonical_querystring\n$canonical_headers\n$signed_headers\n$payload_hash";

			$algorithm = "AWS4-HMAC-SHA256";
			$credential_scope = "$datestamp/{$this->region}/s3/aws4_request";

			$string_to_sign = "$algorithm\n$amzdate\n$credential_scope\n" . hash('sha256', $canonical_request);

			$signingKey = $this->getSigningKey($datestamp);

			$signature = hash_hmac('sha256', $string_to_sign, $signingKey);

			$authorization = "$algorithm Credential={$this->accessKey}/$credential_scope, SignedHeaders=$signed_headers, Signature=$signature";

			$url = "https://$host/$key";

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				"x-amz-date: $amzdate",
				"Authorization: $authorization",
				"x-amz-content-sha256: $payload_hash"
			]);

			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			if (curl_errno($ch)) {
				throw new Exception(curl_error($ch));
			}

			curl_close($ch);

			return [
				'status' => ($httpCode == 204 ? 'success' : 'error'),
				'http'   => $httpCode,
				'key'    => $key,
				'raw'    => $response
			];

		} catch (Exception $e) {

			return [
				'status' => 'error',
				'message' => $e->getMessage()
			];
		}
	}



	public function deleteMultipleObjects($filePaths = []){
		try {
			
			if (empty($filePaths) || !is_array($filePaths)) {
				throw new Exception('No files provided');
			}

			$keys = [];

			// ✅ Extract keys
			foreach ($filePaths as $filePath) {

				if (empty($filePath)) continue;

				if (filter_var($filePath, FILTER_VALIDATE_URL)) {
					$parsed = parse_url($filePath);
					if (empty($parsed['path'])) continue;
					$key = ltrim($parsed['path'], '/');
				} else {
					$key = ltrim($filePath, '/');
				}

				$keys[] = $key;
			}

			if (empty($keys)) {
				throw new Exception('No valid keys found');
			}

			// ✅ Build XML body
			$xml = "<Delete>";
			foreach ($keys as $k) {
				$xml .= "<Object><Key>{$k}</Key></Object>";
			}
			$xml .= "</Delete>";
			
			$contentMd5 = base64_encode(md5($xml, true));

			

			$host = "{$this->bucket}.s3.{$this->region}.amazonaws.com";

			$amzdate = gmdate('Ymd\THis\Z');
			$datestamp = gmdate('Ymd');

			$canonical_uri = "/";
			$canonical_querystring = "delete=";

			//$canonical_headers = "host:$host\nx-amz-date:$amzdate\n";
			//$signed_headers = "host;x-amz-date";
			
			$canonical_headers = "content-md5:$contentMd5\nhost:$host\nx-amz-date:$amzdate\n";
			$signed_headers = "content-md5;host;x-amz-date";

			$payload_hash = hash('sha256', $xml);

			$canonical_request = "POST\n$canonical_uri\n$canonical_querystring\n$canonical_headers\n$signed_headers\n$payload_hash";

			$algorithm = "AWS4-HMAC-SHA256";
			$credential_scope = "$datestamp/{$this->region}/s3/aws4_request";

			$string_to_sign = "$algorithm\n$amzdate\n$credential_scope\n" . hash('sha256', $canonical_request);

			$signingKey = $this->getSigningKey($datestamp);

			$signature = hash_hmac('sha256', $string_to_sign, $signingKey);

			$authorization = "$algorithm Credential={$this->accessKey}/$credential_scope, SignedHeaders=$signed_headers, Signature=$signature";

			$url = "https://$host/?delete";

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				"x-amz-date: $amzdate",
				"Authorization: $authorization",
				"x-amz-content-sha256: $payload_hash",
				"Content-Type: application/xml",
				"Content-MD5: $contentMd5" // 🔥 REQUIRED
			]);

			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			if (curl_errno($ch)) {
				throw new Exception(curl_error($ch));
			}

			curl_close($ch);

			return [
				'status' => ($httpCode == 200 ? 'success' : 'error'),
				'http'   => $httpCode,
				'keys'   => $keys,
				'raw'    => $response
			];

		} catch (Exception $e) {

			return [
				'status' => 'error',
				'message' => $e->getMessage()
			];
		}
	}

	public function objectExists($key)
	{
		$host = "{$this->bucket}.s3.{$this->region}.amazonaws.com";

		$url = $this->getSignedGetUrl($key, 60);

		$headers = @get_headers($url);

		if (!$headers) {
			return false;
		}

		return strpos($headers[0], '200') !== false;
	}
	
	
}