use Google\Cloud\Storage\StorageClient;

$client = new StorageClient();
$bucket = $client->bucket('xxxxxxxxxx'); // 作成したバケット名
$bucket->upload(
    fopen(storage_path('text/test.txt'), 'r')
);
