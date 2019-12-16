<?php
namespace app\models;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use app\components\behaviors\CacheBehavior;
/**
 * Class Activity
 * @package app\models
 *
 * @property-read  User $user
 *@property $dayStart
 *@property $dayEnd
 *@property $title
 *@property $description
 *@property $userID
 *@property $cycle
 *@property $isBlocked
 *@property $id
 *@param $strValue
 *
 */
class Activity extends ActiveRecord
{
    public function behaviors()
    {
        // return BlameableBehavior::class;
        return [
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'author_id',
                'updatedByAttribute' => 'author_id',
            ],
            TimestampBehavior::class,
            CacheBehavior::class => [
                'class' => CacheBehavior::class,
            ],
        ];
    }
    public static function tableName()
    {
        return 'activity';
    }
    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'started_at' => 'Дата начала',
            'finished_at' => 'Дата окончания',
            'author_id' => 'Пользователь',
            'description' => 'Описание',
            'cycle' => 'Повторяемое событие',
            'main' => 'Блокирующее событие',
            'attachments' => 'Прикрепленные файлы',
            'author_email'=>'Электронный адрес автора',
        ];
    }
    public function rules()
    {
        return [
            [['title', 'started_at', 'description'], 'required'],
            [['title', 'description'], 'string'],
            [['title'], 'string', 'min' => 2, 'max' => 160],
            [['description'], 'string', 'min'=> 5],
            [['started_at', 'finished_at'], 'date', 'format' =>'php:d.m.Y H:i:s'],
            [['author_id'], 'default', 'value' => function(){
                return \Yii::$app->user->identity->getId();
            }],
            [['cycle', 'main'], 'boolean'],
            ['finished_at', 'default', 'value' => function(){
                return $this->started_at;
            }],
            ['finished_at','checkDayEnd']
            //[['attachments'], 'file', 'maxFiles' => 5],
        ];
    }
    public function checkDayEnd($strValue)
    {
        $dayStart = strtotime($this->started_at);
        $dayEnd = strtotime($this->finished_at);
        if ($dayEnd < $dayStart) {
            $this->addError($strValue, 'Дата окончания события не может быть раньше даты его начала!');
        }
    }
    public function getUser()
    {
        return $this -> hasOne(User::class, ['id' => 'author_id']);
    }

   /* public static function findOne($condition)
    {
        if (Yii::$app->cache->exists(self::className() . '_' . $condition) === false) {
            $result = parent::findOne($condition);
            Yii::$app->cache->set(self::class . '_' . $condition, $result);
            return $result;
        } else {
            return Yii::$app->cache->get(self::class . '_' . $condition);
        }
    }*/
}