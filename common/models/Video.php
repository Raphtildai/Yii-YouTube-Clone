<?php

namespace common\models;

use Imagine\Image\Box;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\imagine\image;
use yii\db\ActiveQuery; 

/**
 * This is the model class for table "{{%video}}".
 *
 * @property string $video_id
 * @property string $title
 * @property string|null $description
 * @property string|null $tags
 * @property int|null $status
 * @property int|null $has_thumbnail
 * @property string|null $video_name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 *
 * @property User $createdBy
 * @property \common\models\VideoLike[] $likes
 * @property \common\models\VideoLike[] $dislikes
 *
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * Defining constants to be used
     */
    const STATUS_UNLISTED = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * @var \yii\web\UploadedFile
     */
    public $video;

    /**
     * @var \yii\web\UploadedFile
     */
    public $thumbnail;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video}}';
    }

    /**
     * Behaviors
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class, /** This will update the created_at and updated_at fields */
            [
                'class' => BlameableBehavior::class, /** This will update created_by and updated_by fields */
                'updatedByAttribute' => false
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'title'], 'required'],
            [['description'], 'string'],
            [['status', 'has_thumbnail', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['video_id'], 'string', 'max' => 16],
            [['title', 'tags', 'video_name'], 'string', 'max' => 512],
            [['video_id'], 'unique'],
            ['has_thumbnail', 'default', 'value' => 0],
            ['status', 'default', 'value' => self::STATUS_UNLISTED],
            // ['thumbnail', 'file', 'extensions' => 'jpg'],
            [['video'], 'file', 'extensions' => ['mp4']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'video_id' => 'Video ID',
            'title' => 'Title',
            'description' => 'Description',
            'tags' => 'Tags',
            'status' => 'Status',
            'has_thumbnail' => 'Has Thumbnail',
            'video_name' => 'Video Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'thumbnail' => 'Thumbnail',
        ];
    }

    /**
     * Function to return status labels
     */
    public function getStatusLabels()
    {
        return [
            self::STATUS_UNLISTED => 'Unlisted',
            self::STATUS_PUBLISHED => 'Published'
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::class, ['id' => 'created_by']);
    }

    /**
     * Function to get views from the views table
     * @return ActiveQuery
     */
    public function getViews(){
        return $this->hasMany(VideoView::class, ['video_id' => 'video_id']);
    }

    /**
     * Function to return the number of likes for a particular video
     * @return ActiveQuery
     */
    public function getLikes(){
        return $this->hasMany(VideoLike::class, ['video_id' => 'video_id'])->liked();
    }

    /**
     * Function to return the number of dislikes for the video
     * @return ActiveQuery
     */
    public function getDisLikes()
    {
        return $this->hasMany(VideoLike::class, ['video_id' => 'video_id'])->disLiked();
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\VideoQuery(get_called_class());
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $isInsert = $this->isNewRecord;
        if ($isInsert) {
            $this->video_id = Yii::$app->security->generateRandomString(8);
            $this->title = $this->video->name;
            $this->video_name = $this->video->name;
        }
        
        if($this->thumbnail){
            $this->has_thumbnail = 1;
        }
        $saved = parent::save(
            $runValidation, $attributeNames
        );
        /** 
         * if for some reason the video was not saved return false
         */
        if (!$saved) {
            return false;
        }
        if ($isInsert) {
            $videoPath = Yii::getAlias('@frontend/web/storage/videos/'.$this->video_id.'.mp4', $throwException = true);
            if (!is_dir(dirname($videoPath))) {
                FileHelper::createDirectory(dirname($videoPath));
            }
            $this->video->saveAs($videoPath);
        }

        if($this->thumbnail){
            $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbs/'.$this->video_id.'.jpg', $throwException = true);
            if (!is_dir(dirname($thumbnailPath))) {
                FileHelper::createDirectory(dirname($thumbnailPath));
            }
            $this->thumbnail[0]->saveAs($thumbnailPath);
            Image::getImagine()
                ->open($thumbnailPath)
                ->thumbnail(new Box(1280, 1280))
                ->save();
        }
        return true;
    }

    /**
     * A function to get video link
     */
    public function getVideoLink()
    {
        return Yii::$app->params['frontendUrl'].'/storage/videos/'.$this->video_id.'.mp4';
    }

    /**
     * Function to get thumbnail link
     */
    public function getThumbnailLink()
    {
        return $this->has_thumbnail ? 
            Yii::$app->params['frontendUrl'].'/storage/thumbs/'.$this->video_id.'.jpg'
            : '';
    }

    /**
     * We need to clean up the files once the video is deleted
     */
    public function afterDelete()
    {
        parent::afterDelete();
        $videoPath = Yii::getAlias('@frontend/web/storage/videos/'.$this->video_id.'.mp4', $throwException = true);
        // Check if the video exists
        if(file_exists($videoPath)){
            unlink($videoPath);
        }
        $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbs/'.$this->video_id.'.jpg', $throwException = true);
        // Check if the thumbnail exists
        if(file_exists($thumbnailPath)){
            unlink($thumbnailPath);
        }
    }

    /**
     * Function to check if the user has liked the video or not
     */
    public function isLikedBy($userId)
    {
        return VideoLike::find()
            ->userIdVideoId($userId, $this->video_id);
            // ->liked()
            // ->one();
    }

    /**
     * Function to check if the user has disliked the video or not
     */
    public function isDisLikedBy($userId)
    {
        return VideoLike::find()
            ->userIdVideoId($userId, $this->video_id);
            // ->disLiked()
            // ->one();
    }
}
