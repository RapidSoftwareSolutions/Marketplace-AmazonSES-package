<?php

$app->post('/api/AmazonSES/createReceiptRule', function ($request, $response, $args) {
    
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['apiKey','apiSecret','region','ruleSetName','ruleName']);
    if(!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback']=='error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $post_data = $validateRes;
    }

    $credentials = new Aws\Credentials\Credentials($post_data['args']['apiKey'], $post_data['args']['apiSecret']);

    $client = new Aws\Ses\SesClient([
        'version'     => 'latest',
        'region'      => $post_data['args']['region'],
        'credentials' => $credentials
    ]);
    
    $body['RuleSetName'] = $post_data['args']['ruleSetName'];
    if(!empty($post_data['args']['after'])) {
        $body['After'] = $post_data['args']['after'];
    }
    $body['Rule']['Name'] = $post_data['args']['ruleName'];
    if(!empty($post_data['args']['actions'])) {
        $body['Rule']['Actions'] = $post_data['args']['actions'];
    }
    if(!empty($post_data['args']['enabled'])) {
        $body['Rule']['Enabled'] = $post_data['args']['enabled'];
    }
    if(!empty($post_data['args']['scanEnabled'])) {
        $body['Rule']['ScanEnabled'] = $post_data['args']['scanEnabled'];
    }
    if(!empty($post_data['args']['tlsPolicy'])) {
        $body['Rule']['TlsPolicy'] = $post_data['args']['tlsPolicy'];
    }
    if(!empty($post_data['args']['recipients'])) {
        $body['Rule']['Recipients'] = $post_data['args']['recipients'];
    }
    
    try {
        $res = $client->createReceiptRule($body)->toArray();
                
        $result['callback'] = 'success';
        $result['contextWrites']['to'] = is_array($res) ? $res : json_decode($res);
        if(empty($result['contextWrites']['to'])) {
            $result['contextWrites']['to']['status_msg'] = "Api return no results";
        }
    } catch (S3Exception $e) {
        // Catch an S3 specific exception.
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $e->getMessage();
    } catch (\Exception $e) {
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $e->getMessage();
    }
    
    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);
    
});
