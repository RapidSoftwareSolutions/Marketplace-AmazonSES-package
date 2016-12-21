<?php

$app->post('/api/AmazonSES/createConfigurationSetEventDestination', function ($request, $response, $args) {
    
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ['apiKey','apiSecret','region','configurationName','destinationName','matchingEventTypes']);
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
    
    $body['ConfigurationSetName'] = $post_data['args']['configurationName'];
    $body['EventDestination']['Name'] = $post_data['args']['destinationName'];
    $body['EventDestination']['MatchingEventTypes'] = $post_data['args']['matchingEventTypes'];
    if(!empty($post_data['args']['enabled'])) {
        $body['EventDestination']['Enabled'] = $post_data['args']['enabled'];
    }
    if(!empty($post_data['args']['cloudWatchDestination'])) {
        $body['EventDestination']['CloudWatchDestination'] = $post_data['args']['cloudWatchDestination'];
    }
    if(!empty($post_data['args']['deliveryStreamARN'])) {
        $body['EventDestination']['KinesisFirehoseDestination']['DeliveryStreamARN'] = $post_data['args']['deliveryStreamARN'];
    }
    if(!empty($post_data['args']['IAMRoleARN'])) {
        $body['EventDestination']['KinesisFirehoseDestination']['IAMRoleARN'] = $post_data['args']['IAMRoleARN'];
    }
    
    try {
        $res = $client->createConfigurationSetEventDestination($body)->toArray();
                
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
