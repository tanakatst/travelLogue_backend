<?php

namespace App\Services\Utilities;

use Google\Cloud\Storage\Bucket;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use stdClass;

class UtilityService
{

    public Bucket $bucket;
    public array $bucketOptions;

    public function __construct()
    {
        $projectId = Config('app.google_project_bucket_name');
        $url = file_get_contents(storage_path('../storage/acount_key.json', true));
        $client = new StorageClient([
            'projectId' => $projectId,
            'keyFile' => json_decode($url, true)
        ]);
        $this->bucket = $client->bucket($projectId);
        $this->bucketOptions = [
            'resumable' => true, // アップロードを再開可能に行うか
            'name' => '',
            'metadata' => [
                // 日本語化
                'contentLanguage' => 'ja'
            ]
        ];
    }

    /**
     * admin権限のアクセスチェック
     *
     * @return bool
     */
    public function isAccessByAdmin(): bool
    {
        return Gate::allows('admin');
    }

    /**
     * 仮登録GCS保存名を作成
     *
     * @param UploadedFile $file
     * @param string $dirName
     * @param string $uniqueKey
     * @param array $options
     * @return array
     */
    public function setBucketOptions(UploadedFile $file, string $dirName, string $uniqueKey, array $options): array
    {
        $extension = $file->extension();
        $fileName = "{$uniqueKey}_{$dirName}.{$extension}";

        // 保存ディレクトリ生成
        $options['name'] = "tmp/skill_sheet/{$uniqueKey}/{$dirName}/{$fileName}";
        return $options;
    }

    /**
     * サムネイル画像情報をクラスに詰める
     * @param $thumbnailFile
     * @param $targetId
     * @param $model
     * @param $thumbnailFileName
     * @param $thumbnailFileObject
     * @return stdClass
     */
    public function setThumbnailClass($thumbnailFile, $targetId, $model, $thumbnailFileName, $thumbnailFileObject): stdClass
    {
        $thumbnailClass = new stdClass();
        $thumbnailClass->original_name = is_null($thumbnailFile) && !is_null($targetId) ? $model->thumbnail_file_name : $thumbnailFile->getClientOriginalName();
        $thumbnailClass->name = is_null($thumbnailFile) && !is_null($targetId) ? $model->thumbnail_path : $thumbnailFileName;
        $thumbnailClass->single_url = is_null($thumbnailFile) && !is_null($targetId) ? $model->thumbnail_path : $thumbnailFileObject->signedUrl(time() + 3600);
        return $thumbnailClass;
    }
}
