<?php
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the CrudCode object
 */
?>
<?php echo "<?php\n"; ?>

/**
 * This is the model class for table "<?php echo $this->tableNameWithoutPrefix; ?>".
 */
class <?php echo $this->modelClass; ?> extends <?php echo $this->baseClass."\n"; ?>
{
	/**
	 * The followings are the available columns in table '<?php echo $this->tableNameWithoutPrefix; ?>':
<?php foreach($this->getColumns() as $column): ?>
	 * @var <?php echo $column->type.' $'.$column->name."\n"; ?>
<?php endforeach; ?>
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '<?php echo $this->tableNameWithoutPrefix; ?>';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
<?php foreach($this->getRules() as $rule): ?>
			<?php echo $rule.",\n"; ?>
<?php endforeach; ?>
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('<?php echo implode(', ', array_keys($this->getColumns())); ?>', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
<?php foreach($this->getRelations() as $name=>$relation): ?>
			<?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
<?php foreach($this->getLabels() as $name=>$label): ?>
			<?php echo "'$name' => '$label',\n"; ?>
<?php endforeach; ?>
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

<?php
foreach($this->getColumns() as $name=>$column)
{
	if($column->type==='string')
	{
		echo "\t\t\$criteria->compare('$name',\$this->$name,true);\n\n";
	}
	else
	{
		echo "\t\t\$criteria->compare('$name',\$this->$name);\n\n";
	}
}
?>
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}