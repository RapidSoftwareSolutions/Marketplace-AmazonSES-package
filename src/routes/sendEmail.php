<?php

$app->post('/api/AmazonSES/sendEmail', function ($request, $response, $args) {
    
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['apiKey','apiSecret','region','destination','message','fromEmail']);
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
    
    $body['Destination'] = $post_data['args']['destination'];
    $body['Message'] = $post_data['args']['message'];
    $body['Source'] = $post_data['args']['fromEmail'];
    if(!empty($post_data['args']['configurationSetName'])) {
        $body['ConfigurationSetName'] = $post_data['args']['configurationSetName'];
    }
    if(!empty($post_data['args']['replyToAddresses'])) {
        $body['ReplyToAddresses'] = $post_data['args']['replyToAddresses'];
    }
    if(!empty($post_data['args']['returnPath'])) {
        $body['ReturnPath'] = $post_data['args']['returnPath'];
    }
    if(!empty($post_data['args']['returnPathArn'])) {
        $body['ReturnPathArn'] = $post_data['args']['returnPathArn'];
    }
    if(!empty($post_data['args']['SourceArn'])) {
        $body['sourceArn'] = $post_data['args']['sourceArn'];
    }
    if(!empty($post_data['args']['tags'])) {
        $body['Tags'] = $post_data['args']['tags'];
    }
    
    try {
        $res = $client->sendEmail($body)->toArray();
                
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
