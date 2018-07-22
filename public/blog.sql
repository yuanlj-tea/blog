/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : blog

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2018-07-22 21:54:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for blog_article
-- ----------------------------
DROP TABLE IF EXISTS `blog_article`;
CREATE TABLE `blog_article` (
  `art_id` int(11) NOT NULL AUTO_INCREMENT,
  `art_title` varchar(100) DEFAULT '' COMMENT '//文章标题',
  `art_tag` varchar(100) DEFAULT '' COMMENT '//关键词',
  `art_description` varchar(255) DEFAULT '' COMMENT '//描述',
  `art_thumb` varchar(255) DEFAULT '' COMMENT '//缩略图',
  `art_content` text COMMENT '//内容',
  `art_time` int(11) DEFAULT '0' COMMENT '//发布时间',
  `art_editor` varchar(50) DEFAULT '' COMMENT '//作者',
  `art_view` int(11) DEFAULT '0' COMMENT '//查看次数',
  `cate_id` int(11) DEFAULT '0' COMMENT '//分类id',
  PRIMARY KEY (`art_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='//文章';

-- ----------------------------
-- Records of blog_article
-- ----------------------------
INSERT INTO `blog_article` VALUES ('11', '村主任向补助对象索取感谢费被处分', '村主任,感谢费', '作为村委会主任，本该清廉勤政为村民办实事办好事，但我却罔顾党纪，滋生贪念，在协助乡政府从事农户申报危房改造补助工作过程中，以请客吃饭为名，向补助对象索取‘感谢费’，最终付出了代价。', 'uploads/20160408102557869.jpg', '<p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">作为村委会主任，本该清廉勤政为村民办实事办好事，但我却罔顾党纪，滋生贪念，在协助乡政府从事农户申报危房改造补助工作过程中，以请客吃饭为名，向补助对象索取‘感谢费’，最终付出了代价。”这是江西省上饶市广丰区少阳乡少阳村村委会主任余瑞平在接受组织调查时痛心的悔悟。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　2014年12月12日，广丰区纪委接到一封信访举报件，反映“少阳村村委会主任余瑞平利用职务之便向一名困难群众夏种芳索要3000元”。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　区纪委次日即成立调查组，迅速赶往少阳乡少阳村展开调查。调查组查看了该村危房改造补助资金发放的账单，同时约谈了少阳乡分管民政的副乡长、少阳村支书、驻组村干部及夏种芳等人，初步认定举报基本属实。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　证据确凿后，调查组立即约谈了余瑞平。“是夏种芳自愿送给我的‘辛苦费’。”刚开始，余瑞平还抱着侥幸心理，百般抵赖。当证据摆在面前时，他面红耳赤地低下了头，最后承认自己违规的事实。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　夏种芳是农村特困户，其居住的房屋是祖辈遗留给他的一处破旧不堪的危房。2011年年底，夏种芳听说“困难户可以申请危房改造补助”，于是请亲戚代其写了一份危房补助申请送到村委会，村、乡按申报程序逐级上报。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　2012年10月，夏种芳的房屋通过区里的验收小组验收后，区里分当年年末、次年年初两次每次7500元共15000元，下拨给夏种芳个人。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　2013年3月，夏种芳第二笔危房改造补助款到账后，余瑞平来到夏种芳家询问其危房改造补助款下拨情况。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　夏种芳说，“第一笔钱已经收到并使用了，第二笔钱才刚刚收到，还没来得及去取。”余瑞平应声说，“你这个补助名额，是我们村里和乡里考虑到你家庭困难，大家努力为你争取来的。如果你有诚意就拿2000元钱出来，由我替你请大家到餐馆吃个饭表达下你的心意。”</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　过了几天，夏种芳在村委会门口将1500元交到余瑞平手中，而余瑞平将这笔钱占为已有。调查组调查期间，余瑞平将1500元退还给夏种芳。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　问题线索查清后，区纪委立即将此线索移交给少阳乡纪委立案处理。2015年4月27日，少阳党委会研究决定，给予余瑞平党内严重警告处分。（江西省纪委）</p><p><br/></p>', '1460082363', '陈华', '2', '9');
INSERT INTO `blog_article` VALUES ('2', '上海楼市新政半月成交腰斩 踩点买房者陷两难', '上海,楼市', '来自克而瑞研究中心数据显示，上海3月21日-3月27日的一手房日均成交量为10.3万平方米，到了3月28日-4月3日的日均成交量急速下跌至4.5万平方米，环比下跌56%。', 'uploads/20160408091742986.jpg', '<p>　 &nbsp;上海史上最严新政落地短短半月，市场正呈现另一番景象。</p><p><br/></p><p>　　<span style=\"color: rgb(192, 0, 0);\">来自克而瑞研究中心数据显示，上海3月21日-3月27日的一手房日均成交量为10.3万平方米，到了3月28日-4月3日的日均成交量急速下跌至4.5万平方米，环比下跌56%。</span></p><p><br/></p><p>　　21世纪经济报道记者近日走访多家中介，业务员普遍反映预期改变，来客量下滑5-6成，“市场风向变了，这是最明显的降温。”业务员陈颖（化名）说，这样的来客量对以后转化成交易也不是很有力。</p><p><br/></p><p>　　业内资深人士陈开朝指出，一线城市进入存量房交易主导时代；上海首次在人口净流入为负的情况下严厉调控楼市，在实际需求（至少是租赁需求）减少的情况下，市场预期下滑，肯定会推动量价齐跌；北上深楼市增长的驱动力结构已发生根本变化，新的调控主要针对本轮楼市回暖的第一驱动力——改善需求。</p><p><br/></p><p>　　21世纪经济报道记者近日走访多家中介，业务员普遍反映客户预期改变，访客量下滑5-6成，浦东一些门店访客量甚至下滑7-8成。“市场风向变了，这是最明显的降温。”业务员陈颖（化名）说，这样的访客量对以后转化成交易也不会很给力。</p><p><br/></p><p>　　在上述三种力作用下，上海的成交量面临下滑。</p><p><br/></p><p><strong>　　一、二手市场冷却轨迹</strong></p><p><br/></p><p>　　二手房网签数据的下滑可以看出市场冷却轨迹：上海中原地产数据显示，上海3月20日-3月24日的二手房网签套数为11220套，3月25日新政开始执行后，3月25日-3月31日网签8915套。</p><p><br/></p><p>　　新政前当月累计住宅成交量5.5万套，异常火爆。上海二手房指数办公室透露，“3·25”新政前，在改善性置换强劲推动下，中环以内中高端房大涨后的挤出效应，外围房源紧缺导致涨声一片，全市再现普涨格局。其中，改善客成交占比六成以上，一些首置刚需则畏于高房价退出市场。有业主连续跳价，有的不惜毁约唯恐低卖。</p><p><br/></p><p>　　而“3·25”新政后一周，成交萎缩二至四成，板块看房量大降三至八成，减量中非户籍看房客约占六成。新政后违约案例骤增，退房成潮或逾三成。截至2016年3月31日，全市二手住宅挂牌量为132248套，较上月上升7.5%。</p><p><br/></p><p>　　上海中原地产市场分析师卢文曦指出，一些全新入市的项目不排除会有低于市场预期的价格入市。对于有的新盘，周边的二手房价格不低，加上税费可能还高于新房，所以这些项目的价格相对会比较坚挺些。总的来说，房企定价会随行就市，价格的定制会简单理性。</p><p><br/></p><p>　　然而，上述克而瑞研究报告却指出，在过去一周热销楼盘中，仍然是房价上涨的项目更多。并且在上海的嘉定新城、松江泗泾等热点板块，标杆项目近一周备案房价较3月月均涨幅更是达到了4%。</p><p><br/></p><p>　　土地市场的变化也显而易见。2016年上海商品房土地供应量比去年提高了169公顷。尽管政府提出了加大土地供应量，但从实际表现来看，土地供应依然不足。今年第一季度土地成交面积63.49公顷，比去年同期下滑67.8%，成交金额205.68亿元，同比下滑33.4%。不过值得注意的是尽管土地成交面积下滑，第一季度住宅用地成交面积37.67公顷，比去年同期下滑63.7%，但土地成交金额仅小幅下滑6.8%。</p><p><br/></p><p>　　上海中原市场研究中心资深经理龚敏指出，土地供应量加大是否如计划执行还有待验证，地价受交易降温影响下回调的可能性加大。</p><p><br/></p><p>　　陈开朝又指出，从调控的出发点看，政府的主要意图是为抑制当前一线城市房价疯涨势头，防止疯涨后的“断崖式”下跌。但一线城市楼市行情“急冻”，肯定会带动二线和三四线楼市降温。</p><p><br/></p><p>　　陈开朝指出，“沪3·25”、“深3·25”，包括以后可能出台的北京调控，某种程度上都是对2015年过度放任的一种矫枉过正。为了避免调控对合理置业需求和经济转型升级的误伤，后续调控应该加大政府土地供应价格的自律和对开发商和业主涨价行为的管控；应该有效地管控房价涨幅，让其温和地释放。</p><p><br/></p><p><strong>　　二、买家进退两难</strong></p><p><br/></p><p>　　值得一提的是，在3月25日新政实施当天网签而又不符合新政规定的购买者，陷入了两难境地：不甘心退房，因为等条件符合新政规定或许又要几年后，这些购房者出于对房价上涨的心理预期而不愿意退房；交易中心的流程已经没法往下走，如果不退房，目前购房者只有继续与中介、卖家各方僵持。</p><p><br/></p><p>　　而这当中牵涉多个一手楼盘，不确定是否退房的房源暂时无法统计，但按照3月25日一手房网签2495套、二手房网签2398套来测算，牵涉退房的数量规模不小。</p><p><br/></p><p>　　尽管楼市疯狂褪去，但外地购房者的心态并没有改变，仍然希望买房安居上海。根据3月25日新政发布会当天现场宣布的新政从3月25日开始执行，多名业内人士认为政策回旋余地不大。</p><p><br/></p><p>　　燕子（化名）是一名80后妈妈，夫妻两人均是外地户籍，此前因为社保缴纳年限不足24个月而一直没有买房，而且因为在上海没有房子，燕子的女儿在读收费比公立幼儿园贵不少的私立幼儿园。因此尽管年初房价暴涨，购房条件刚符合旧政策要求的燕子便加入了购房大军，但由于没有赶到3月24日晚上24点之前网签成功，因此新政实施后，燕子直接被挡在了门外。</p><p><br/></p><p>　　像燕子这样由于社保问题被挡在门外的刚需买家并不少。并且，他们在购买之前普遍经历过上一手卖家的跳价，出于对房价上涨的预期，他们中的大部分是希望交易完成的。</p><p><br/></p><p>　　新政的影响，部分还牵涉到交易链的上下家。例如，张明（化名）是3月19日签的定金合同，付了定金20万。当时约定的是3月30日交首付80多万。张明和女朋友本来计划3月24日回老家，25日去领结婚证。3月24日晚上，张明接到中介电话突然说，现在购房资格审核提前，没有结婚证之前的录入系统不算，25日清早张明和女友去领证，中介说当天25日录了系统。然而新政当天出台，张明累积个税有6年，但是连续少了4个月。现在张明要买的房子业主已经买了要置换的房子，暂时没法退20万定金。张明的20万就这样悬空了。</p><p><br/></p><p>　　因此，易居研究院智库中心研究总监严跃进指出，相关部门后续在打击投资投机需求的同时，需要重点关注外来人口的住房问题。大力发展租赁市场，既是规避限购等政策，也是比较务实的做法。</p><p><br/></p><p>　　克而瑞研究中心分析师杨科伟分析认为，一线城市供不应求基本面不变，短期内房价下跌可能性不大，但受政策收紧影响，成交规模将有所收窄，并且在前期惯性消耗殆尽之后，一线城市年中或将出现新一轮的缩量；二线城市政策面依然趋宽，部分热点城市虽然开始出台房价调控，但力度相对有限，市场热度有望继续保持，而武汉、成都、合肥等近年城建快速发展、人口基数较大的单中心城市，市场规模更有进一步向上突破的可能。沪、深各类产品需求占比相对稳定，存量需求释放后成交才会真正下探。</p><p><br/></p>', '1460078343', '陈华', '6', '1');
INSERT INTO `blog_article` VALUES ('3', '《美人鱼》精准营销炼就高票房 三次元电影如何玩转二次元？', '美人鱼,周星驰', '截至4月6日，在上映59天后，由周星驰执导的春节档大片《美人鱼》总票房已达33.9亿元，不仅成为中国内地电影历史票房冠军，而且几乎刷新了国内所有票房的相关纪录。根据艺恩EBOT日票房智库显示，该片累计观影场次为212万，人次为9237万。', 'uploads/20160408101155467.jpg', '<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 2em; font-size: 15px; color: rgb(51, 51, 51); font-family: tahoma, arial, 微软雅黑, 宋体; line-height: 30px; white-space: normal; background-color: rgb(255, 255, 255);\">截至4月6日，在上映59天后，由周星驰执导的春节档大片《美人鱼》总票房已达33.9亿元，不仅成为中国内地电影历史票房冠军，而且几乎刷新了国内所有票房的相关纪录。根据艺恩EBOT日票房智库显示，该片累计观影场次为212万，人次为9237万。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 2em; font-size: 15px; color: rgb(51, 51, 51); font-family: tahoma, arial, 微软雅黑, 宋体; line-height: 30px; white-space: normal; background-color: rgb(255, 255, 255);\">而在艺恩春节档观众满意度调研中，《美人鱼》凭借84.7的总分获得第一，比去年同期的第一名《狼图腾》高出2分。可以看到，这部三年磨一剑的作品在票房与口碑上都同样出色。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 2em; font-size: 15px; color: rgb(51, 51, 51); font-family: tahoma, arial, 微软雅黑, 宋体; line-height: 30px; white-space: normal; background-color: rgb(255, 255, 255);\">事实上，除了影片在主创上具有吸引力、“合家欢”基调契合档期消费诉求外，《美人鱼》的“无敌”亦离不开其在营销上的别出心裁。无论是无提前点映保持神秘感、借助“周星驰”这一IP主打情怀牌还是玩转二次元营销，这部影片的营销都有着很多不可复制的成功之处。尤其是作为一部三次元电影，在这个以电影为中心的营销时代，其在突破次元壁垒以及撬动二次元受众上可谓树立了标杆式的范本。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 2em; font-size: 15px; color: rgb(51, 51, 51); font-family: tahoma, arial, 微软雅黑, 宋体; line-height: 30px; white-space: normal; background-color: rgb(255, 255, 255);\"><strong style=\"margin: 0px; padding: 0px;\">Step1 饥饿营销保持影片神秘感 &nbsp;情怀杀摒弃“欠票”梗</strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 2em; font-size: 15px; color: rgb(51, 51, 51); font-family: tahoma, arial, 微软雅黑, 宋体; line-height: 30px; white-space: normal; background-color: rgb(255, 255, 255);\">尽管《美人鱼》早早就定下了春节档，但是在大年初一正式上映之前，该片的故事内容和人物设置却没有过早曝光。在同档期电影纷纷启动点映时，《美人鱼》没有设置任何提前看片场，包括媒体、影评人、行业从业者在内的所有人与普通观众一样，都需要在2月8日才能一睹影片芳容。这种“饥饿营销”的方式，积累了强大的观影情绪，为上映前获取关注度和上映后转化为消费力助力颇多。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 2em; font-size: 15px; color: rgb(51, 51, 51); font-family: tahoma, arial, 微软雅黑, 宋体; line-height: 30px; white-space: normal; background-color: rgb(255, 255, 255);\">根据艺恩EFMT电影营销智库监测，在2月上映的一众影片中，《美人鱼》的认知指数和购票指数遥遥领先，与其事先吊足大众胃口不无关系。</p><p><br/></p>', '1460081522', '陈华', '0', '8');
INSERT INTO `blog_article` VALUES ('4', '倚天屠龙记李连杰版 精武英雄李连杰', '张无忌,李连杰', '《倚天屠龙记之魔教教主》永盛电影公司1993年出品的电影，改编自小说《倚天屠龙记》，由王晶担任导演和编剧，李连杰、邱淑贞、张敏、洪金宝等主演。', 'uploads/20160408101316515.jpg', '<p><span style=\"color: rgb(51, 51, 51); font-family: ����, Arial; font-size: 14px; line-height: 26px; text-indent: 28px;\">《倚天屠龙记之魔教教主》永盛电影公司1993年出品的电影，改编自小说《倚天屠龙记》，由王晶担任导演和编剧，李连杰、邱淑贞、张敏、洪金宝等主演。该片讲述了张无忌学会了九阳神功、乾坤大挪移，揭破了朝廷歼灭六大门派的阴谋，救出了他外公和师祖的故事。影片于1993年12月18日上映。</span></p><p><strong style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: ����, Arial; font-size: 14px; line-height: 26px; text-indent: 28px; white-space: normal;\">精武英雄李连杰</strong><span style=\"color: rgb(51, 51, 51); font-family: ����, Arial; font-size: 14px; line-height: 26px; text-indent: 28px;\">，《精武英雄》翻拍自李小龙主演的电影《精武门》。由正东制作有限公司出品的一部动作电影。由陈嘉上执导，陈嘉上、叶广俭、林纪陶合作编剧，李连杰、钱小豪、中山忍、蔡少芬、仓田保昭、周比利、秦沛联袂主演。该片讲述的是陈真追查师父死因，他请医生验尸，证实师父霍元甲确系藤田刚下毒致死。与其展开了连场恶斗之后藤田刚挑战精武门，藤田刚诱使日本黑龙会总教头船越文夫向精武馆挑战。比武之日，双方展开决战，最终陈真获胜为师父报仇的故事。《精武英雄》于1994年12月22日在中国香港公映。</span></p>', '1460081601', '陈华', '0', '1');
INSERT INTO `blog_article` VALUES ('5', '总局发2015年2、3月电视动画备案公示', '动画,广电总局', '近日总局公开2016年2月、3月全国全国国产电视动画片制作备案公示的通知，据公示说明2016年2月，经备案公示的全国国产电视动画片为34部，2016年3月，经备案公示的全国国产电视动画片为23部。', 'uploads/20160408101409922.jpg', '<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 2em; font-size: 15px; color: rgb(51, 51, 51); font-family: tahoma, arial, 微软雅黑, 宋体; line-height: 30px; white-space: normal; background-color: rgb(255, 255, 255);\">近日总局公开2016年2月、3月全国全国国产电视动画片制作备案公示的通知，据公示说明2016年2月，经备案公示的全国国产电视动画片为34部，2016年3月，经备案公示的全国国产电视动画片为23部。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 2em; font-size: 15px; color: rgb(51, 51, 51); font-family: tahoma, arial, 微软雅黑, 宋体; line-height: 30px; white-space: normal; background-color: rgb(255, 255, 255);\">具体情况如下所示：</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 2em; font-size: 15px; color: rgb(51, 51, 51); font-family: tahoma, arial, 微软雅黑, 宋体; line-height: 30px; white-space: normal; background-color: rgb(255, 255, 255);\">2016年2月，经备案公示的全国国产电视动画片为34部，14009分钟。按题材划分，历史题材5部、2656分钟，占备案公示总数的14.7%、19.0%；童话题材15部、6596分钟，占备案公示总数的44.1%、47.1%；教育题材2部、188分钟，占备案公示总数的5.9%、1.3%；现实题材2部、680分钟，占备案公示总数的5.9%、4.9%；科幻题材5部、2420分钟,占备案公示总数的14.7%、17.3%；其他题材5部、1570分钟,占备案公示总数的14.7%、11.2%。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; text-indent: 2em; font-size: 15px; color: rgb(51, 51, 51); font-family: tahoma, arial, 微软雅黑, 宋体; line-height: 30px; white-space: normal; background-color: rgb(255, 255, 255);\">按所占比例大小排名，备案公示的国产电视动画片题材依次为：童话题材、历史题材、科幻题材、其他题材、现实题材、教育题材。</p><p><br/></p>', '1460081668', '后盾网', '0', '1');
INSERT INTO `blog_article` VALUES ('6', '白宫下封口令禁止美军将领谈南海问题', '美国,南海问题', '美国《海军时报》网站7日报道称，围绕南海问题，美国太平洋司令部司令哈里斯最近正暗中积极寻求更具对抗性的手段，试图“回击和逆转中国的南海战略优势”', 'uploads/20160408101541221.jpg', '<p style=\"margin-top: 0px; margin-bottom: 20px; padding: 0px; line-height: 32px; font-size: 18px; font-family: &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;STHeiti Light&#39;, 华文细黑, SimSun, 宋体, Arial, sans-serif; white-space: normal;\">美国《海军时报》网站7日报道称，围绕南海问题，美国太平洋司令部司令哈里斯最近正暗中积极寻求更具对抗性的手段，试图“回击和逆转中国的南海战略优势”。不过，他的这些诉求屡在白宫碰壁，<strong>美国总统国家安全事务助理苏珊·赖斯甚至曾在核安全峰会前夕要求哈里斯和其他军方人士在南海问题上“闭嘴”。</strong></p><p style=\"margin-top: 0px; margin-bottom: 20px; padding: 0px; line-height: 32px; font-size: 18px; font-family: &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;STHeiti Light&#39;, 华文细黑, SimSun, 宋体, Arial, sans-serif; white-space: normal;\">　　报道称，哈里斯和他的太平洋司令部过去几个月不停地在公开和私下场合拔高中国“攫取南海岛礁的做法”。他一直游说美国国家安全委员会（NSC）、国会和五角大楼，向中国发出明确信号，强调美方不能容忍中国“欺负邻居”。有消息人士对《海军时报》表示，哈里斯想在巡航频次上翻倍。曾担任美国海军作战部长乔纳森·格林纳特的高级顾问的卜瑞安·克拉克表示，哈里斯正寻求在南海岛礁12海里之内利用直升机等采取军事行动，“他想进行真正的自由航行”。</p><p style=\"margin-top: 0px; margin-bottom: 20px; padding: 0px; line-height: 32px; font-size: 18px; font-family: &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;STHeiti Light&#39;, 华文细黑, SimSun, 宋体, Arial, sans-serif; white-space: normal;\">　　不过，距离结束任期只有9个月的奥巴马正加强与中国在核不扩散、贸易等方面的合作。美国智库新美国安全中心专家、退役海军上校杰瑞·亨德里克斯认为，“奥巴马政府希望在任期结束时与中国之间的乱子最小，合作最大”。克拉克说，NSC会定期审查海军作战部长的言论。专家称，奥巴马政府不想给南海添乱。</p><p style=\"margin-top: 0px; margin-bottom: 20px; padding: 0px; line-height: 32px; font-size: 18px; font-family: &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;STHeiti Light&#39;, 华文细黑, SimSun, 宋体, Arial, sans-serif; white-space: normal;\">　　两名五角大楼官员披露称，赖斯曾在核安全峰会前夕向哈里斯和其他美军官员下了封口令，<strong>要求他们在那段时间不要对中国的南海活动进行公开评论，以保障奥巴马与中方在核峰会期间会谈时有“最大的政治操作空间”。</strong>据称，封口令是3月18日NSC会议的内容之一。熟悉此次会议的美国官员称：“我们谈论中国的举动有时可以，有时不行。与此同时，中国向外传递的信息始终一致。”军方人士认为，对中国的“强硬举动”沉默这样胆小的反应会让中国更加大胆，让被欺负的盟友更担心。美国参议员麦凯恩对《海军时报》称，“白宫的避险行为导致政策制定犹豫不决，这无法威慑中国”。专家称，奥巴马政府经常要求军方在会谈前降低嗓门，但现在正值艰难时刻。美方正寻求在与中国不发生对峙的情况下，有效阻止其造岛行动。</p><p style=\"margin-top: 0px; margin-bottom: 20px; padding: 0px; line-height: 32px; font-size: 18px; font-family: &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;STHeiti Light&#39;, 华文细黑, SimSun, 宋体, Arial, sans-serif; white-space: normal;\">　　《海军时报》就其了解的上述内容向哈里斯和美国海军作战部询问时，对方都拒绝置评。美国海军行政人员只是说，他们就涉及中国的问题上保持部门之间的沟通。《海军时报》评论称，封口令至少有了一个效果。美国的一艘两栖攻击舰和一艘海滩登陆舰3月底通过南海时，悄悄然无人知晓。</p><p><br/></p>', '1460081749', '后盾网', '5', '9');
INSERT INTO `blog_article` VALUES ('7', '深圳楼市调控措施立竿见影：成交量连续5周下滑', '深圳,成交量', '3月25日，上海发布实施九条房地产调控措施，包括非户籍人士购房社保缴纳年限从累计2年提高到连续5年，二套非普通住房首付比例从四成激增到七成', 'uploads/20160408101821971.jpg', '<p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">近两周来，房地产调控措施的降温效果明显，上海、深圳的楼市成交量遭遇“速冻”。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　3月25日，上海发布实施九条房地产调控措施，包括非户籍人士购房社保缴纳年限从累计2年提高到连续5年，二套非普通住房首付比例从四成激增到七成，限购资格审核流程从交易阶段前置到了签约环节等；同日出台的深圳版调控措施，提出实施提高房贷首付、从严收紧限购等。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　调控措施效果立竿见影，市场如期降温。信义房屋企研室监测数据显示，上海二手商品住宅在3月24日成交曾猛增至4400套，之后锐减，保持在1000套左右，仅为3月前期水平的一半。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　记者从上海多家二手房中介门店了解到，清明小长假3天，上海中环以外区域门店来客量比平时减少4成至5成，而类似<span id=\"stock_sh600663\"><a href=\"http://finance.sina.com.cn/realstock/company/sh600663/nc.shtml\" class=\"keyword\" target=\"_blank\" style=\"color: rgb(17, 62, 170); text-decoration: none;\">陆家嘴</a></span><span id=\"quote_sh600663\">(<span style=\"color:black\">38.610</span>,&nbsp;<span style=\"color:black\">0.00</span>,&nbsp;<span style=\"color:black\">0.00%</span>)</span>这样的中心区门店，来客量比平时减少7成至8成。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　有银行个贷部人员告诉记者，近两周前来办理贷款的购房人少了五六成，“以前每周至少20组，现在只有不到10组。”中原地产门店业务员说：“现在不少卖家下调报价，一套房的挂牌价可下调10万元至30万元，基本接近年初的价格水平。”</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　深圳规划和国土资源委员会的数据显示，3月28日至4月3日，深圳一手住宅成交652套，成交面积约7.05万平方米，分别环比下滑16%和15.7%。这已经是深圳新房成交面积连续第五周下滑，与春节前的周成交量相比接近腰斩。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　对未来房价预期则出现分歧。经济学家<a class=\"wt_article_link\" href=\"http://weibo.com/lawma?zw=finance\" target=\"_blank\" style=\"color: rgb(17, 62, 170); text-decoration: none;\">马光远</a>认为，上海、深圳的房价已透支了全年的涨幅。而在调控周期下，整个市场预期已经出现明显逆转，同时很多具有购买能力但没有购房资格的人将退出市场，因此深圳、上海的房价不排除下跌调整的可能。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　有房企负责人认为，由于地价高企，且前期大量成交所导致的开发商大量回款，短期内期望房价下降并不现实。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　上海财经大学不动产研究所所长陈杰表示，通过加强资金流的约束提高二套房首付比例，可以大幅提高炒房成本，一定程度上会抑制投机炒作。“楼市短期内会冷却一段时间，但还要警惕反弹。上海2015年房地产开发量和新开工都不旺盛，供给回升需要一个周期。”</p><p><br/></p>', '1460081905', '后盾网', '0', '8');
INSERT INTO `blog_article` VALUES ('8', '部分山寨社团被曝光后仍有活动', '山寨,活动', '在“中华民营企业联合会年会——专题页”网页上，“中华民营企业联合会”称，该组织于2013年1月25日在北京钓鱼台国宾馆举行年会，歌唱家蒋大为献唱。', 'uploads/20160408101938116.jpg', '<p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　在“中华民营企业联合会年会——专题页”网页上，“中华民营企业联合会”称，该组织于2013年1月25日在北京钓鱼台国宾馆举行年会，歌唱家蒋大为献唱。网络截图</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　新京报讯 近日，民政部在中国社会组织网陆续曝光了3批共228家“离岸社团”、“山寨社团”名单，还公布了曝光后已注销的3家组织名单。民政部相关负责人表示，将监控“山寨社团”，对继续以该组织名义开展活动的及时处罚。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　据民政部民间组织管理局局长詹成付介绍，这些山寨协会主要是内地居民利用境内外对社会组织登记管理制度的差异，在登记条件宽松的国家和地区进行注册的，如美国、澳大利亚、中国香港等地。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　“这些组织通过开展活动、吸收会员、设立分支组织的形式行骗敛财。”詹成付称，山寨协会的敛财手段主要有发展会员、成立分会收取会费，发牌照、搞评选颁奖活动收钱，搞行业培训收费等方式，也有些山寨组织直接对企业敲诈勒索。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; line-height: 2em; font-family: &#39;Microsoft YaHei&#39;, u5FAEu8F6Fu96C5u9ED1, Arial, SimSun, u5B8Bu4F53; white-space: normal;\">　　詹成付表示，民政部将对曝光名单进行动态管理，及时更新，并对已注销的社团进行监控。如果这些注册在境外的山寨组织，未登记或未取得临时活动许可开展活动的，将予以取缔，没收非法财物所得，对责任人进行警告、罚款甚至拘留。</p><p><br/></p>', '1460081995', '后盾网', '0', '8');
INSERT INTO `blog_article` VALUES ('9', '王凯：花式吻戏我害羞 感情上我主动', '新浪,王凯', '新浪娱乐讯 4月7日，电视剧《欢乐颂》在杭州举办发布会，刘涛[微博]、蒋欣[微博]、王子文[微博]、乔欣、王凯[微博]、祖峰等主演亮相。', 'uploads/20160408102048702.jpg', '<p>新浪娱乐讯 4月7日，电视剧《欢乐颂》在杭州举办发布会，刘涛[微博]、蒋欣[微博]、王子文[微博]、乔欣、王凯[微博]、祖峰等主演亮相。制片人侯鸿亮透露，第二部已经启动，将保证完整原班人马。而王凯则自曝在剧中无时无刻不在花式接吻，自己很害羞，而在感情中，自己也是主动型的，“我喜欢就大方去追，就说出来。”据悉，刘涛的女儿将在剧中献出荧幕首秀，但她表示女儿不会因此进军娱乐圈。此外，刘涛还爆料，蒋欣对两位男演员靳东[微博]和霍建华十分中意。</p><p><br/></p><p>　　制片人侯鸿亮：第二部已启动 保证原班人马</p><p><br/></p><p>　　自去年《琅琊榜》《伪装者》霸屏之后，其背后的东阳正午阳光影视有限公司浮出水面，而《欢乐颂》是这个团队的第一部女性题材作品。据悉，该剧由孔笙[微博]、简川訸[微博]执导，袁子弹编剧，侯鸿亮制片，改编自阿耐的同名小说，讲述了各自携带往事和憧憬的五位女性先后住进欢乐颂小区22楼，彼此间产生的交集以及各自的情感故事。</p><p><br/></p><p>　　“他们说我会拍男人戏，不会拍女人戏，这次就要拍一部女人戏。”导演孔笙打趣道。 而制片人侯鸿亮则现场透露，《欢乐颂》第二部项目已经启动，剧本正在创作中，预计今年9月开机，明年春天与观众见面。第二部会保证原班人马，“所有男女主角，哪怕是小配角都不会有变动。”</p><p><br/></p>', '1460082082', '陈华', '12', '11');
INSERT INTO `blog_article` VALUES ('10', '曝中国企业与巴萨谈胸前赞助 巴萨球衣前印汉字?', '体育,赞助商', '你能想象，巴萨球衣前面印上中国汉字吗？如今看来，这个设想真有可能变成现实。根据《每日体育报》的报道，一家中国公司正在和巴萨进行谈判，有可能成为巴萨新的球衣胸前赞助商。', 'uploads/20160408102224712.jpg', '<p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; font-size: 14px; line-height: 23px; color: rgb(51, 51, 51); font-family: 宋体; white-space: normal; background-color: rgb(255, 255, 255);\">你能想象，巴萨球衣前面印上中国汉字吗？如今看来，这个设想真有可能变成现实。根据《每日体育报》的报道，一家中国公司正在和巴萨进行谈判，有可能成为巴萨新的球衣胸前赞助商。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; font-size: 14px; line-height: 23px; color: rgb(51, 51, 51); font-family: 宋体; white-space: normal; background-color: rgb(255, 255, 255);\">　　巴萨如今的球衣胸前赞助商是卡塔尔航空公司，双方从2013年开始合作，此后3个赛季的总赞助金额为1.65亿欧元，合同于今年6月30日到期。此前，由于巴萨方面提高要价，双方一直没有就续约事宜达成一致。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; font-size: 14px; line-height: 23px; color: rgb(51, 51, 51); font-family: 宋体; white-space: normal; background-color: rgb(255, 255, 255);\">　　《每日体育报》报道称，在与卡塔尔方面就续约继续谈判的同时，巴萨也在寻找其他可能的新赞助商，其中就包括一家中国公司。<strong>报道称，双方的谈判目前还处于初级阶段，该中方公司的名字也还没有曝光，能否在下赛季开始前达成协议，还要打上一个大大的问号。</strong></p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; font-size: 14px; line-height: 23px; color: rgb(51, 51, 51); font-family: 宋体; white-space: normal; background-color: rgb(255, 255, 255);\">　　据悉，如果巴萨与其他赞助商达成一致，卡塔尔航空有匹配报价的权利。《每日体育报》还报道称，巴萨方面不打算在价格上让步，为了找到合适的赞助商，他们甚至不惜“裸奔”一年。</p><p><br/></p>', '1460082149', '后盾网', '0', '1');
INSERT INTO `blog_article` VALUES ('12', '最强大脑挑战围棋速成未果 成人普及迎新希望', '最强大脑,围棋', '4月7日下午，最强大脑挑战速成围棋活动在新浪网演播室结束，四位最强大脑人气选手经过了五天半的围棋特训，最终在挑战环节中，被让九子对阵世界冠军遗憾落败。', 'uploads/20160408102712947.jpg', '<p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; font-size: 14px; line-height: 23px; color: rgb(51, 51, 51); font-family: 宋体; white-space: normal; background-color: rgb(255, 255, 255);\">4月7日下午，最强大脑挑战速成围棋活动在新浪网演播室结束，四位最强大脑人气选手经过了五天半的围棋特训，最终在挑战环节中，被让九子对阵世界冠军遗憾落败，对阵围棋人工智能两盘棋因为直播时间的缘故未能下完，两位最强大脑棋手形势不佳。不过四位最强大脑的棋艺得到了职业棋手的肯定，四人也表示围棋非常有趣，后面还要继续学习。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; font-size: 14px; line-height: 23px; color: rgb(51, 51, 51); font-family: 宋体; white-space: normal; background-color: rgb(255, 255, 255);\">　　围棋变化无穷，博大精深，但围棋的规则其实非常简单。知道“气”和“眼”的概念，就可以下棋了。但更进一步的了解攻防，战斗，子效，棋理等就需要多年的积累和参悟，这也是在围棋普及工作上遇到的最大困难。很多人对围棋感兴趣，但由于时间成本太高，只能知难而退。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; font-size: 14px; line-height: 23px; color: rgb(51, 51, 51); font-family: 宋体; white-space: normal; background-color: rgb(255, 255, 255);\">网名为“真疯叔叔”的围棋教练李振沣发明了一套适用于成年人的教学方法，把围棋的理念与现实生活中的道理类比，让人先明白围棋中的道理，然后在对弈中感悟，实践，与普通的教学方法相比，反其道而行之。</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; font-size: 14px; line-height: 23px; color: rgb(51, 51, 51); font-family: 宋体; white-space: normal; background-color: rgb(255, 255, 255);\">　　围棋速成法一出，真疯叔叔和教学团队就不止一次表态，这套教学方法不适用于少儿培训。举个简单到例子，关于棋子之间的关系、配合，真疯叔叔是用职场之间人与人之间的关系类比的，成年人可以很轻松的明白其中关键，但给孩子解释起来就不知从何说起了……</p><p style=\"margin-top: 15px; margin-bottom: 15px; padding: 0px; font-size: 14px; line-height: 23px; color: rgb(51, 51, 51); font-family: 宋体; white-space: normal; background-color: rgb(255, 255, 255);\">　　这种教学方法在成人普及中取得了非常不错的效果，四位最强大脑虽然只是学习了五天半的围棋，但已经基本能够看懂围棋的攻守争战。虽然在局部计算上肯定还有欠缺，但用他们队长王昱珩的话说：“人机大战的时候我可以得意的告诉别人，我知道李世石和阿尔法在做什么了。”</p><p><br/></p>', '1460082468', '后盾网', '3', '11');
INSERT INTO `blog_article` VALUES ('13', '考完主持人考普通话 孟非：这碗饭吃得险象环生', '孟非,主持人', '名嘴孟非在网上发文感慨“主持人这碗饭吃得险象环生”，文中称：“刚通过主持人上岗考试还没几天，又接到通知要我参加普通话等级测试。这碗饭吃得越发险象环生了……”', 'uploads/20160408103118110.jpg', '<p style=\"margin-top: 1em; margin-bottom: 1em; padding: 0px; border: 0px; outline: none; list-style: none; font-family: 宋体; line-height: 28.8px; white-space: normal; background-color: rgb(255, 255, 255);\">　今日，名嘴孟非在网上发文感慨“主持人这碗饭吃得险象环生”，文中称：“刚通过主持人上岗考试还没几天，又接到通知要我参加普通话等级测试。这碗饭吃得越发险象环生了……”名嘴也是烦恼颇多。</p><p style=\"margin-top: 1em; margin-bottom: 1em; padding: 0px; border: 0px; outline: none; list-style: none; font-family: 宋体; line-height: 28.8px; white-space: normal; background-color: rgb(255, 255, 255);\">　　有网友表示：“闹半天你这么多年是无证主持～”，也有网友安慰孟非：“你要是上德云社说相声，还得考你贯口和绕口令呢。普通话，小菜一碟!”，更有网友直言：“咱是靠脸吃饭的好吗？”</p><p><br/></p>', '1460082704', '后盾网', '0', '8');
INSERT INTO `blog_article` VALUES ('14', '苹果7/7 Plus齐曝光:双摄像头 售价提高', '苹果,摄像头', '国外科技媒体BGR指出，Youtube频道「iPhone-Tricks.com」释出一段iPhone 7概念视频。从视频中可以看到该概念iPhone 7采取完全无边框的是设计，搭配OLED屏幕；而Touch ID与屏幕融为一体。', 'uploads/20160408113758707.jpg', '<p style=\"margin-top: 20px; margin-bottom: 0px; padding: 0px; border: 0px; line-height: 32px; color: rgb(36, 36, 36); font-family: &#39;Microsoft YaHei&#39;; white-space: normal; background-color: rgb(255, 255, 255);\">　国外科技媒体BGR指出，Youtube频道「iPhone-Tricks.com」释出一段iPhone 7概念视频。从视频中可以看到该概念iPhone 7采取完全无边框的是设计，搭配OLED屏幕；而Touch ID与屏幕融为一体。此外，Touch ID除了解锁以外，还有更多好用的功能，比如说快速查看信息、拨打电话等。</p><p style=\"margin-top: 20px; margin-bottom: 0px; padding: 0px; border: 0px; line-height: 32px; color: rgb(36, 36, 36); font-family: &#39;Microsoft YaHei&#39;; white-space: normal; background-color: rgb(255, 255, 255);\">　　此外，郭明池还表示，5.5寸版本的iPhone 7 Plus要用双摄像头，这是跟4.7寸版本最明显的区别，当然售价也会提高一些，同时该机的造型可能不会那么惊艳，毕竟大家对新一代iPhone的期望有些过高了。</p><p style=\"margin-top: 20px; margin-bottom: 0px; padding: 0px; border: 0px; line-height: 32px; color: rgb(36, 36, 36); font-family: &#39;Microsoft YaHei&#39;; white-space: normal; background-color: rgb(255, 255, 255);\">　　之前就有消息称，苹果想要iPhone 4.7寸和5.5寸之间的差距更明显，而现在双摄像头的运用，的确是一个不错的办法，而对于国内用户来说，首选应该iPhone 7 Plus了吧，不管外形有多平庸，售价有多贵，是吧？</p><p><br/></p>', '1460082782', '后盾网', '7', '8');

-- ----------------------------
-- Table structure for blog_category
-- ----------------------------
DROP TABLE IF EXISTS `blog_category`;
CREATE TABLE `blog_category` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(50) DEFAULT '' COMMENT '//分类名称',
  `cate_title` varchar(255) DEFAULT '' COMMENT '//分类说明',
  `cate_keywords` varchar(255) DEFAULT '' COMMENT '//关键词',
  `cate_description` varchar(255) DEFAULT '' COMMENT '//描述',
  `cate_view` int(10) DEFAULT '0' COMMENT '//查看次数',
  `cate_order` tinyint(4) DEFAULT '0' COMMENT '//排序',
  `cate_pid` int(11) DEFAULT '0' COMMENT '//父级id',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='//文章分类';

-- ----------------------------
-- Records of blog_category
-- ----------------------------
INSERT INTO `blog_category` VALUES ('1', '新闻', '搜集国内外最热门的新闻资讯', '新闻,后盾网', '搜集国内外最热门的新闻资讯，搜集国内外最热门的新闻资讯', '25', '1', '0');
INSERT INTO `blog_category` VALUES ('2', '体育', '发展体育事业，增强国民体质', '体育新闻', '发展体育事业，增强国民体质', '1', '2', '0');
INSERT INTO `blog_category` VALUES ('3', '娱乐', '人人都有自己的娱乐圈', '', '', '1', '3', '0');
INSERT INTO `blog_category` VALUES ('9', '军事新闻', '最新军事新闻_中国军事新闻_国际军事新闻军情网站', '', '', '2', '4', '1');
INSERT INTO `blog_category` VALUES ('8', '热点新闻', '最新新闻事件_热点新闻_热点事件网', '', '', '9', '2', '1');
INSERT INTO `blog_category` VALUES ('10', '体育彩票', '体育彩票管理中心唯一指定官方网站', '', '', '0', '2', '2');
INSERT INTO `blog_category` VALUES ('11', '乐视体育', '最专业的体育赛事平台', '', '', '0', '1', '2');
INSERT INTO `blog_category` VALUES ('12', '腾讯体育', '人气最旺的体育门户', '', '', '0', '3', '2');

-- ----------------------------
-- Table structure for blog_config
-- ----------------------------
DROP TABLE IF EXISTS `blog_config`;
CREATE TABLE `blog_config` (
  `conf_id` int(11) NOT NULL AUTO_INCREMENT,
  `conf_title` varchar(50) DEFAULT '' COMMENT '//标题',
  `conf_name` varchar(50) DEFAULT '' COMMENT '//变量名',
  `conf_content` text COMMENT '//变量值',
  `conf_order` int(11) DEFAULT '0' COMMENT '//排序',
  `conf_tips` varchar(255) DEFAULT '' COMMENT '//描述',
  `field_type` varchar(50) DEFAULT '' COMMENT '//字段类型',
  `field_value` varchar(255) DEFAULT '' COMMENT '//类型值',
  PRIMARY KEY (`conf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_config
-- ----------------------------
INSERT INTO `blog_config` VALUES ('1', '网站标题', 'web_title', '后盾Blog系统', '1', '网站大众化标题', 'input', '');
INSERT INTO `blog_config` VALUES ('2', '统计代码', 'web_count', '百度统计', '3', '网站访问情况统计', 'textarea', '');
INSERT INTO `blog_config` VALUES ('3', '网站状态', 'web_status', '0', '2', '网站开启状态', 'radio', '1|开启,0|关闭');
INSERT INTO `blog_config` VALUES ('5', '辅助标题', 'seo_title', '后盾网 人人做后盾', '4', '对网站名称的补充', 'input', '');
INSERT INTO `blog_config` VALUES ('6', '关键词', 'keywords', '北京php培训,php视频教程,php培训,php基础视频,php实例视频,lamp视频教程', '5', '', 'input', '');
INSERT INTO `blog_config` VALUES ('7', '描述', 'description', '后盾网顶尖PHP培训，最专业的网站开发php培训，小班化授课，全程实战！业内顶级北京php培训讲师亲自授课，千余课时php独家视频教程免费下载，数百G原创视频资源，实力不容造假！抢座热线：400-682-3231', '6', '', 'textarea', '');
INSERT INTO `blog_config` VALUES ('8', '版权信息', 'copyright', 'Design by 后盾网 <a href=\"http://www.houdunwang.com\" target=\"_blank\">http://www.houdunwang.com</a>', '7', '', 'textarea', '');

-- ----------------------------
-- Table structure for blog_failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `blog_failed_jobs`;
CREATE TABLE `blog_failed_jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_failed_jobs
-- ----------------------------
INSERT INTO `blog_failed_jobs` VALUES ('1', 'redis', 'testQueue', '{\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"data\":{\"command\":\"O:13:\\\"App\\\\Jobs\\\\test\\\":5:{s:5:\\\"\\u0000*\\u0000id\\\";i:111;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";s:9:\\\"testQueue\\\";s:5:\\\"delay\\\";N;s:6:\\\"\\u0000*\\u0000job\\\";N;}\"},\"id\":\"svvILaa46RgiacCCSNcFqviSErapQlHg\",\"attempts\":4}', '2018-06-22 10:20:13');

-- ----------------------------
-- Table structure for blog_links
-- ----------------------------
DROP TABLE IF EXISTS `blog_links`;
CREATE TABLE `blog_links` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '//名称',
  `link_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '//标题',
  `link_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '//链接',
  `link_order` int(11) NOT NULL DEFAULT '0' COMMENT '//排序',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_links
-- ----------------------------
INSERT INTO `blog_links` VALUES ('3', '后盾网', '国内口碑最好的PHP培训机构', 'http://www.houdunwang.com', '2');
INSERT INTO `blog_links` VALUES ('4', '后盾论坛', '后盾网，人人做后盾', 'http://bbs.houdunwang.com', '1');
INSERT INTO `blog_links` VALUES ('5', '快学网', '后盾网旗下在线教育平台', 'http://www.kuaixuewang.com', '3');

-- ----------------------------
-- Table structure for blog_migrations
-- ----------------------------
DROP TABLE IF EXISTS `blog_migrations`;
CREATE TABLE `blog_migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of blog_migrations
-- ----------------------------
INSERT INTO `blog_migrations` VALUES ('2016_04_11_095342_create_links_table', '1');
INSERT INTO `blog_migrations` VALUES ('2018_06_21_181029_create_failed_jobs_table', '2');

-- ----------------------------
-- Table structure for blog_navs
-- ----------------------------
DROP TABLE IF EXISTS `blog_navs`;
CREATE TABLE `blog_navs` (
  `nav_id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_name` varchar(50) DEFAULT '' COMMENT '//名称',
  `nav_alias` varchar(50) DEFAULT '' COMMENT '//别名',
  `nav_url` varchar(255) DEFAULT '' COMMENT '//url',
  `nav_order` int(11) DEFAULT '0' COMMENT '//排序',
  PRIMARY KEY (`nav_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_navs
-- ----------------------------
INSERT INTO `blog_navs` VALUES ('1', '首页', 'Protal', 'http://blog.hd', '1');
INSERT INTO `blog_navs` VALUES ('2', '关于我', 'About', 'http://blog.hd/a/14', '2');
INSERT INTO `blog_navs` VALUES ('3', '新闻', 'News', 'http://blog.hd/cate/1', '3');
INSERT INTO `blog_navs` VALUES ('4', '碎言碎语', 'Doing', 'http://', '4');
INSERT INTO `blog_navs` VALUES ('5', '模板分享', 'Share', 'http://', '5');
INSERT INTO `blog_navs` VALUES ('6', '学无止境', 'Learn', 'http://', '6');
INSERT INTO `blog_navs` VALUES ('7', '留言版', 'Gustbook', 'http://', '7');

-- ----------------------------
-- Table structure for blog_user
-- ----------------------------
DROP TABLE IF EXISTS `blog_user`;
CREATE TABLE `blog_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) DEFAULT '' COMMENT '//用户名',
  `user_pass` varchar(255) DEFAULT '' COMMENT '//密码',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='//管理员';

-- ----------------------------
-- Records of blog_user
-- ----------------------------
INSERT INTO `blog_user` VALUES ('1', 'admin', 'eyJpdiI6IlBBNTJjV2ZkWkp3TXZvQm5xdGR3R2c9PSIsInZhbHVlIjoiM3RGYVg3U2pCellJbEdHTlwvS0MzTWc9PSIsIm1hYyI6ImRmYzdjZDhmNGQ2N2I5MTBjOTMxYjdkYmMzNGExZThhZmE2YWMxNGUzYWIzYWM5Mzg4MTQyZDI4OGJkMzJhYTUifQ');
SET FOREIGN_KEY_CHECKS=1;
