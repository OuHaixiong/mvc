 <?php

/**
 * 测试Sphinx全文检索
 * @author Bear[258333309@163.com]
 * @version 1.0
 * @created 2018年7月20日 下午5:09:25
 */
class C_Sphinx extends BController
{
	public function init() {
        parent::init();
	}
	
	/**
	 * 通过sphinx搜索，源为postgresql
	 */
	public function search() {
	    include_once ROOT_PATH . '/../../libraries/sphinxapi.php';
	    $br = '<br />';
	    $keywords = '南京市长江大桥';
	    $keywords = 'iphone X?';
	    $keywords = '哈哈哈你好';
	    echo $keywords, $br;
// 	    $keywords = '华为v10手机';
//         $keyword = '手机';
//         $keyword = '华为';
//         $keyword = '123';
	    $keyword = $this->wordSplit($keywords);
        echo("keyword=>{$keyword}<br />");
        $sphinx = new SphinxClient();
        $sphinx->SetServer('172.17.10.253', 9312);
        $sphinx->SetConnectTimeout(3); // 连接超时时间，单位：秒
//         $sphinx->SetMatchMode(SPH_MATCH_ANY); // 匹配模式。 这个参数貌似在中文里面没有什么作用。并且在最新版中貌似已去掉， 匹配模式是历史遗留问题
        // SPH_MATCH_ALL     ：完全匹配【匹配所有查询词】（缺省模式）; 
        // SPH_MATCH_PHRASE  : 短语匹配；
        // SPH_MATCH_ANY     : 匹配任意查询词；
        // SPH_MATCH_EXTENDED: 查询匹配一个Sphinx内部查询语言表达式； 扩展查询语法(Extended query syntax)
                             // 在SPH_MATCH_EXTENDED模式中，最终的权重是短语权重和BM25权重的总和，再乘以1000取整
        // SPH_MATCH_BOOLEAN : 布尔表达式匹配 。 布尔查询可以使用 &、|、-、!等，如：hello | world
//         $sphinx->SetMatchMode(SPH_MATCH_EXTENDED); // 
//         $sphinx->SetArrayResult(true); // 特别注意此参数，默认为false：结果($result['matches'])的key为主键id； 如果设置为true：会把主键id放在value中

        // 下面实现按权重进行查找
        $sphinx->SetRankingMode(SPH_RANK_PROXIMITY); // 设置等级模式(排序)。这里为：设置评分模式
        // SPH_RANK_NONE : 禁用排序，所有的匹配项都被赋予权重1。性能最优
        // SPH_RANK_WORDCOUNT : 所有的关键字出现的次数并乘以用户设置的字段权重排序
        // SPH_RANK_FIELDMASK ： 匹配字段的位标识
        // SPH_RANK_PROXIMITY : 短语相似度,通过简单的短语相似算法得到一个权重值.与上面BM25截然相反，根本不关心关键词出现的频率和查询关键词在文档中的位置。
                             // 代替BM25使用的关键词频率，Sphinx分析关键词在每个字段的位置，并且用最长公共子串算法.越相似的短语将排在前面，而精确匹配的短语将排在非常前面
        // SPH_RANK_MATCHANY : 任意关键词. 结合了短语相似算法和匹配关键字次数，因此每个字段默认权重，a)较长子短语匹配（即更大短语相似）在任何字段将获得更高的排序，
                             //b)与短语相似一致，文档匹配不同关键字越多则排名越高。换句话说，先看最大匹配子短语的长度，再看匹配不同关键字的数量。
        // SPH_RANK_BM25 : 匹配关键字出现频率。 匹配字段用户设置的权重和BM25的总和。 和PROXIMITY_BM25模式基本相似，除了用户权重没有乘以每个字段的短语相似值。
                         //不使用短语相似允许引擎只使用文档列表来评估搜索，跳过处理关键字出现。BM25是一个只依赖于匹配关键字出现频率的浮点数值。
        // SPH_RANK_PROXIMITY_BM25 : 短语相似度和BM25.使用词组评分和 BM25 评分。 文档短语相似度是主要因子，BM25是辅助部分，当相同的短语相似时进行附加的文档排序
        // SPH_RANK_SPH04 : 完全匹配+最开始短语匹配+某处短语相匹配+普通短语匹配. 短语相似仍然是主导因素，但是当给定一个短语相似的时候，在字段最开始匹配将排序更高，
                          // 如果是整个字段完全匹配的话将排到最高处。 例如，当查询“Market Street”，SPH04模式基本上将某个字段完全匹配“Market Street”的文档排序在最前面，
                          // 接着排像“Market Street Grocery”这样在字段最开始匹配的文档，然后排像“WestMarket Street”这样在字段某处有与短语相匹配的文档，
                          // 最后排那些有包含短语所有关键字但不是一个短语的文档（例如，“Flea Market on 26th Street”）。

        $sphinx->SetFieldWeights(array('title'=>5, 'type_name'=>3)); // 设置字段的权重，如果title命中，那么权重*5
        $sphinx->SetSortMode('SPH_SORT_RELEVANCE', '@weight'); // 按照权重排序。 特别注意，这里第一个参数传入的是字符串（很奇怪，其实不奇怪，第一个参数为空就可以了）
//         $sphinx->SetSortMode(SPH_SORT_ATTR_DESC, 'update_time'); // 排序，按照更新时间的倒序排。这里的第一个参数是整形
//         $sphinx->SetSortMode(SPH_SORT_EXTENDED, '@relevance DESC,update_time ASC'); // 多重排序 (奇怪，搞笑竟然不能多重排序，靠)
        /*SPH_SORT_RELEVANCE     : 按相关度降序排列（最好的匹配排在最前面） 忽略任何附加的参数，永远按相关度评分排序。所有其余的模式都要求额外的排序子句，子句的语法跟具体的模式有关。
        SPH_SORT_ATTR_DESC     : 按属性降序排列 （属性值越大的越是排在前面）
        SPH_SORT_ATTR_ASC      : 按属性升序排列（属性值越小的越是排在前面）
        SPH_SORT_TIME_SEGMENTS : 先按时间段（最近一小时/天/周/月）降序，再按相关度降序。 这种模式是为了方便对Blog日志和新闻提要等的搜索而增加的。使用这个模式时，
                               // 处于更近时间段的记录会排在前面，但是在同一时间段中的记录又根据相关度排序－这不同于单纯按时间戳排序而不考虑相关度
        SPH_SORT_EXTENDED      : 按一种类似SQL的方式将列组合起来，升序或降序排列。(貌似在最新版里面这个有问题，还是改了，因为最新版中不能识别@weight等内部属性)
                                                                                        可以指定一个类似SQL的排序表达式，但涉及的属性（包括内部属性）不能超过5个，如： @relevance DESC, price ASC, @id DESC
                                                                                        使用@开头的为内部属性，用户属性按原样使用就行。
                                                                                        内置属性有：
                                 @id (匹配文档的 ID)
                                 @weight (匹配权值) 【@rank 和 @relevance 只是 @weight 的别名】
                                 @rank (等同 weight)
                                 @relevance (等同 weight)
                                 @random (随机顺序返回结果)
        SPH_SORT_EXPR          : 按某个算术表达式排序。（这个在最新版里已经去掉了）
        
        * SPH_SORT_ATTR_ASC,SPH_SORT_ATTR_DESC以及SPH_SORT_TIME_SEGMENTS这三个模式仅要求一个属性名
        */
        
//         $sphinx->SetFilter(); // 设置过滤条件。 $cl->SetFilter($attribute, $values, $exclude); 最后一个参数默认为false，如果为true时相当于：$attribute!=$value
//         $cl->SetGroupBy($attribute, $func, $groupsort); // 分组
        //设定group by
        //根据分组方法，匹配的记录集被分流到不同的组，每个组都记录着组的匹配记录数以及根据当前排序方法本组中的最佳匹配记录。
        //最后的结果集包含各组的一个最佳匹配记录，和匹配数量以及分组函数值
        //结果集分组可以采用任意一个排序语句，包括文档的属性以及sphinx的下面几个内部属性
        //@id--匹配文档ID
        //@weight, @rank, @relevance--匹配权重
        //@group--group by 函数值
        //@count--组内记录数量
        //$groupsort的默认排序方法是@group desc，就是按分组函数值大小倒序排列
        
        
        $sphinx->SetMaxQueryTime(2000); // 最大查询时间, 单位为:ms(毫秒)
        $sphinx->_offset = 0;
        $sphinx->_limit = 1000;
        
//         $cl->UpdateAttributes ( "products", array ( "price", "amount_in_stock" ),
//             array ( 1001=>array(123,5), 1002=>array(37,11), 1003=>(25,129) ) );
        
        // ->SetLimits ( $offset, $limit, $max=0, $cutoff=0 ) // 设置翻页
//         $result = $sphinx->Query($keyword, 'i_product_delta;i_product'); // query('xxx', '*') *表示在所有索引里面进行搜索
        $result = $sphinx->Query($keyword, 'd_product'); // query('xxx', '*') *表示在所有索引里面进行搜索
        // 也可以读取多个索引：Query($query,"main;delta"),
        if ($result === false) {
            die('Query failed, Error:' . $sphinx->GetLastError());
        }
        $sphinx->Close();
        if ($result['total'] == 0 || !isset($result['matches']) || empty($result['matches'])) {
            die('没有符合的记录');
        }
        
        echo $result['total'], $br;
        
//         var_dump($sphinx); // object(SphinxClient)
        var_dump($result);echo $br;
//         foreach ($result['matches'] as $key=>$doc) {
//             var_dump($key);
//             var_dump($doc);
//         }
        $idsArray = array_keys($result['matches']);
        $ids = implode(',', $idsArray);
        
        $dbName = 'ybapi';
        $host = '172.17.6.140';
        $port = '5432';
        $user = 'ybapi';
        $password = '123456';
        $pdo = new PDO("pgsql:dbname={$dbName};host={$host};port={$port}", $user, $password);
        $sql = 'select * from product where id in(' . $ids . ')';
        echo $sql, $br;
        $statement = $pdo->prepare($sql); // order by position(id::text in '1,3,2,4')
        if (!$statement) {
            die($statement->errorInfo());
        }
//         $statement->bindParam(':ids', $ids); // 这样会自动加上引号的
        $statement->execute();
        $rowset = $statement->fetchAll();
        $html = '';
        $tempData = array();
        foreach ($rowset as $k=>$row) {
            $tempData[$row['id']] = $row;
        }
        foreach ($idsArray as $k=>$v) {
            if (isset($tempData[$v])) {
                $html .= "{$k} ： id=>{$tempData[$v]['id']} name={$tempData[$v]['title']} info={$tempData[$v]['info']} ";
                $sql = "SELECT t.title||' '||t2.title as type_name FROM product_type t left join product_type t2 on t.parent_id=t2.id WHERE t.id={$tempData[$v]['product_type_id']}";
                $statement = $pdo->prepare($sql);
                $statement->execute();
                $row = $statement->fetch();
                $html .= " type_name={$row['type_name']}<br />";
            }
        }
        echo $html;
	}
	
    /**
     * Chinese words segmentation(中文分词)
     * @param string $keywords
     * @return string
     */
    public function wordSplit($keywords) {
        $fpath = ini_get('scws.default.fpath');
        $scws = scws_new();
        $scws->set_charset('utf-8');
        $scws->add_dict($fpath . '/dict.utf8.xdb'); // 添加默认词库
        // 貌似可以添加多个词库，如：add_dict($fpath .'/custom_dict.txt', SCWS_XDICT_TXT);
        $scws->set_rule($fpath . '/rules.utf8.ini'); // 默认规则
        $scws->set_ignore(true); // 设定分词返回结果时是否去除一些特殊的标点符号 
        $scws->set_multi(false); // 设定分词返回结果时是否复式分割，如“中国人”返回“中国＋人＋中国人”三个词。  
 // 按位异或的 1 | 2 | 4 | 8 分别表示: 短词 | 二元 | 主要单字 | 所有单字  
 //1,2,4,8 分别对应常量 SCWS_MULTI_SHORT SCWS_MULTI_DUALITY SCWS_MULTI_ZMAIN SCWS_MULTI_ZALL
        $scws->set_duality(false); // 设定是否将闲散文字自动以二字分词法聚合
        $scws->send_text($keywords); //设定搜索词
        $words = [];
        $results = $scws->get_result();
        foreach ($results as $v) {
            $words[] = "({$v['word']})";
        }
        $words[] = "({$keywords})"; // 加入全词
        $scws->close();
        return implode('|', $words);
    }
    
    public function update() {
        include_once ROOT_PATH . '/../../libraries/sphinxapi.php';
        $sphinx = new SphinxClient();
        $sphinx->SetServer('172.17.10.253', 9312);
        $sphinx->SetConnectTimeout(3); // 连接超时时间，单位：秒
        $updateField = array('update_time');
        $updateData = array(
           115 => array(time())
        );
        $number = $sphinx->UpdateAttributes('i_product', $updateField, $updateData); // 如果更新失败返回-1，成功返回更新的条数
        // 特别特别注意了：sphinx不能更新索引数据
        var_dump($number);
        // TODO 多个属性值的更新，且多个时类型不一样，如：整型和字符串均需要更新
    }

}