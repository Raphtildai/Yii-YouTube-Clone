<?php

namespace common\models\query;
use Yii;
use \common\models\Video;

/**
 * This is the ActiveQuery class for [[\common\models\Video]].
 *
 * @see \common\models\Video
 */
class VideoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Video[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Video|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    /**
     * Function to return all videos created by this user
     */
    public function creator($userId) {
        return $this->andWhere(['created_by' => $userId]);
    }
    /**
     * Function to return the videos in a sorted manner starting with the latest
     */
    public function latest(){
        return $this->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * Function to return the published videos
     */
    public function published() {
        return $this->andWhere(['status' => Video::STATUS_PUBLISHED]);
    }

    public function byKeyword($keyword)
    {
        return $this->andWhere("MATCH(title, description, tags) AGAINST(:keyword)", ['keyword' => $keyword]);
    }
}
