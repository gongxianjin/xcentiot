<?php

/**
 * 常用调取数据库
 *
 */

class CSXCore {
	 /**
     *    获取收货人信息
     *
     *    @author    Garbin
     *    @param     int $user_id
     *    @return    array
     */
    static function get_my_address($user_id)
    {
        if (!$user_id)
        {
            return array();
        }
		return ShipAddress::model()->findAll('csc_user_id="'.$user_id.'"');
    }
	
	
	/**
     *    获取一级地区
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    static function get_regions()
    {
		$regions=PCA::model()->findAll('csc_parent_id=0');
		if ($regions)
        {
			$tmp  = array();
			foreach ($regions as $key => $value)
            {
				$tmp[$value->csc_id] = $value->csc_name;
			}
			$regions = $tmp;	
		}
		return $regions;
    }
	
	
	 /**
     *    获取配送方式
     *
     *    @author    Garbin
     *    @param     int $store_id
     *    @return    array
     */
    function get_shipping_methods($store_id)
    {
        if (!$store_id)
        {
            return array();
        }
		return Shipping::model()->findAll('csc_enabled = 1 AND csc_store_id="'.$store_id.'"');
    }
	
	
	
	/**
     * 取得某地区的所有子孙地区id
     */
    static public function get_descendant($id)
    {
        $ids = array($id);
        $ids_total = array();
        self::descendant($ids, $ids_total);
        return array_unique($ids_total);
    }
	
	static function descendant($ids, &$ids_total)
    {
		$pca = new CDbCriteria();
		$pca->addCondition('csc_parent_id '.self::db_create_in($ids));
		$pca->select = 'csc_id';
		$childs=PCA::model()->findAll($pca);
		$ids_total = array_merge($ids_total, $ids);
		$ids = array();
        foreach ($childs as $child)
        {
            $ids[] = $child['csc_id'];
        }
        if (empty($ids))
        {
            return ;
        }
        self::descendant($ids, $ids_total);
	}
	
	
	/**
	 * 创建像这样的查询: "IN('a','b')";
	 *
	 * @access   public
	 * @param    mix      $item_list      列表数组或字符串,如果为字符串时,字符串只接受数字串
	 * @param    string   $field_name     字段名称
	 * @author   wj
	 *
	 * @return   void
	 */
	static function db_create_in($item_list, $field_name = '')
	{
		if (empty($item_list))
		{
			return $field_name . " IN ('') ";
		}
		else
		{
			if (!is_array($item_list))
			{
				$item_list = explode(',', $item_list);
				foreach ($item_list as $k=>$v)
				{
					$item_list[$k] = intval($v);
				}
			}
	
			$item_list = array_unique($item_list);
			$item_list_tmp = '';
			foreach ($item_list AS $item)
			{
				if ($item !== '')
				{
					$item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
				}
			}
			if (empty($item_list_tmp))
			{
				return $field_name . " IN ('') ";
			}
			else
			{
				return $field_name . ' IN (' . $item_list_tmp . ') ';
			}
		}
	}
	
}