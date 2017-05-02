<?php
/**
 * 专题管理
 * Enter description here ...
 * @author Administrator
 *
 */
class SpecialController extends Controller {

    /**
     * 初始化方法
     * Enter description here ...
     * @param unknown_type $id
     * @param unknown_type $module
     */
    public function __construct($id, $module=null){
        parent::__construct($id, $module);
        //$this->todo = '专题管理';
    }

	/**
	 *专题列表
	 * Enter description here ...
	 */
	public function actionIndex(){
        //csc_name关键字搜索
        $sword = Yii::app()->request->getParam('sword');
        
        $criteria = new CDbCriteria();
        if (!empty($sword)){
            $criteria->addCondition('locate(:sword,csc_award)');
            $criteria->params['sword'] = $sword;
        }
        
        //分页
        $count = Special::model()->count($criteria);
        $pager = new CPagination($count);
        $pager->pageSize = Yii::app()->params['pages'];
        $pager->applyLimit($criteria);
        
        //排序
        $criteria->order = 'csc_create desc';
        $models = Special::model()->findAll($criteria);
        
        return $this->render('index', array(
            'special' => $models,
            'pages' => $pager,
            'sword'=>$sword,
        ));

	}
    /*
     * 增加专题
     */
    public function actionAdd(){
        if(Yii::app()->request->isPostRequest){
            $amode = Award::model();
            $setting = $amode->find();
            $amin = Yii::app()->request->getParam('amin');
            $amax = Yii::app()->request->getParam('amax');
            if($amax<=0 || $amin<=0){
                $this->jsonMsg(100, '设置值无效', '', '');
            }
            if($amin>$amax){
                $this->jsonMsg(101, '最小值不能超过最大值', '', '');
            }
            if(empty($setting)){
                $model = new Award();
                $model->csc_id = getPrimaryKey($model);
                $model->amin = $amin;
                $model->amax = $amax;
                if(!$model->save()){
                    $error = implode('', current($model->getErrors()));
                    $this->jsonMsg(502, '设置失败'.$error);
                }
            }else{
                $setting->amin = $amin;
                $setting->amax = $amax;
                if(!$setting->save()){
                    $error = implode('', current($setting->getErrors()));
                    $this->jsonMsg(502, '设置失败'.$error);
                }
            }
            $log = '设置抽奖范围';
            $this->addOperLog($log);
            $this->jsonMsg(200, '设置成功', '', $this->createUrl('special/'));
        }else{
            $amode = Award::model();
            $setting = $amode->find();
        }
        return $this->render('add',array(
            'setting'=>$setting,
        ));
    }
    /*
     * 专题修改
     *
     */
    public function actionEdit(){
        $id = Yii::app()->request->getParam('ids');
        if(!$id){
        	$this->redirect(array('special/'));
        }
        
        $special = Special::model()->find('csc_id=:id',array(':id'=>$id));
        if(!$special){
        	$this->redirect(array('special/'));
        }
        //$old_path = $special->csc_path;
        if(Yii::app()->request->isPostRequest){

            //$this->jsonMsg(502, '返回'.Yii::app()->request->getParam('file'));
            $special->csc_name = Yii::app()->request->getParam('csc_name');
            $special->csc_type = Yii::app()->request->getParam('csc_type');
            $special->csc_tpl = Yii::app()->request->getParam('csc_tpl');
            $oldfile = $special->csc_path;
            $file = Yii::app()->request->getParam('file');
            if($file!=$oldfile){
                $unzip = BaseApi::special($special->csc_id, dirname(Yii::app()->basePath).$file);
                if($unzip['code'] != 200){
                    BaseApi::delFile($file);
                    $this->jsonMsg(504, '文件处理失败'.$unzip['msg']);
                }
                $special->csc_path = $unzip['zip_path'];
            }
            
            if(!$special->save()){
            	$error = implode('', current($special->getErrors()));
                $this->jsonMsg(502, '修改失败'.$error);
            }

            $log = '修改专题：'.$special->csc_name;
            $this->addOperLog($log);

            BaseApi::delFile(dirname(Yii::app()->basePath).$file);
            $this->jsonMsg(200, '修改成功', '', $this->createUrl('special/'));
        }


        $this->render('add',array(
        	'special'=>$special,
        ));
    }
    /*
     * 删除
     */
    public function actionDel(){
        $ids = Yii::app()->request->getParam('ids');
        if (!$ids){
        	$this->jsonMsg(410, '参数有误');
        }

        $special = Special::model()->findByPk($ids);
        if (!$special){
        	$this->jsonMsg(520, '参数有误');
        }
        
        if (false === $special->delete()) {
        	$error = implode('', current($special->getErrors()));
            $this->jsonMsg(530, '删除失败'.$error);
        }
        
        BaseApi::specialDel($ids);

        $log = '删除信息: '.$special->csc_name;
        $this->addOperLog($log);

        $this->jsonMsg(200, '删除成功');
    }
    /*
     *
     *  select弹出框
     */

    public function actionSelect(){

        $cate = Special::model()->findAll();

        //$mbs = $this->categoryMbs($topID);

        $this->layout = '/layouts/admin_select';

        return $this->render('select', array(
            'cate' => $cate,
        ));
    }


    /**
     * 导出Excel
     */
    public function actionExport(){
        set_time_limit(0);
        $cond = new CDbCriteria();
        $cond->order = 'csc_create ASC';
        $data = Special::model()->findAll($cond);
        //从execl表中取出排行榜
        Yii::$enableIncludePath=false;
        Yii::import('application.extensions.PHPExcel.PHPExcel',1);
        $objPHPExcel = new PHPExcel();
        // 设置excel文档的属性
        // 开始操作excel表
        $objPHPExcel->getProperties()
            ->setCreator("C1G")
            ->setLastModifiedBy("C1G")
            ->setTitle("phpexcel Test Document")
            ->setSubject("phpexcel Test Document")
            ->setDescription("Test document for phpexcel, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php c1gstudio")
            ->setCategory("Test");
        // 操作第一个工作表
        $objPHPExcel->setActiveSheetIndex(0);
        // 设置工作薄名称
        $objPHPExcel->getActiveSheet()->setTitle(iconv('gbk', 'gbk', '活动用户'));
        // 设置默认字体和大小
        $objPHPExcel->getDefaultStyle()->getFont()->setName(iconv('gbk', 'gbk', '宋体'));
        $objPHPExcel->getDefaultStyle()->getFont()->setSize(12);
        $objPHPExcel->getActiveSheet()->getColumnDimension()->setAutoSize(true);// 列宽自适应 暂未实现
        //放置需要放置的内容
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '编号');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '用户名');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '手机号');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '抽奖号');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '活动类型');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '参与时间');
        $i = 2;
        foreach($data as $key=>$item){
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $item->csc_id);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $item->csc_name);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $item->csc_phone);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $item->csc_award);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $item->csc_type);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $item->csc_create);
            $i++;
        }

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        // 解决IE 下中文显示乱码
        $flie_name = '用户列表';
        $name = autoCharset($flie_name, 'utf-8', 'gbk');
        // 从浏览器直接输出$filename
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$name.'.xls');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

}