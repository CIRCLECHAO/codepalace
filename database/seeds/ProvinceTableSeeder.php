<?php

use Illuminate\Database\Seeder;
class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function __construct()
    {
        $this->sql = "
INSERT INTO provinces (id,province_id,province_name) VALUES (1,'110000','北京市');
INSERT INTO provinces (id,province_id,province_name) VALUES (2,'120000','天津市');
INSERT INTO provinces (id,province_id,province_name) VALUES (3,'130000','河北省');
INSERT INTO provinces (id,province_id,province_name) VALUES (4,'140000','山西省');
INSERT INTO provinces (id,province_id,province_name) VALUES (5,'150000','内蒙古自治区');
INSERT INTO provinces (id,province_id,province_name) VALUES (6,'210000','辽宁省');
INSERT INTO provinces (id,province_id,province_name) VALUES (7,'220000','吉林省');
INSERT INTO provinces (id,province_id,province_name) VALUES (8,'230000','黑龙江省');
INSERT INTO provinces (id,province_id,province_name) VALUES (9,'310000','上海市');
INSERT INTO provinces (id,province_id,province_name) VALUES (10,'320000','江苏省');
INSERT INTO provinces (id,province_id,province_name) VALUES (11,'330000','浙江省');
INSERT INTO provinces (id,province_id,province_name) VALUES (12,'340000','安徽省');
INSERT INTO provinces (id,province_id,province_name) VALUES (13,'350000','福建省');
INSERT INTO provinces (id,province_id,province_name) VALUES (14,'360000','江西省');
INSERT INTO provinces (id,province_id,province_name) VALUES (15,'370000','山东省');
INSERT INTO provinces (id,province_id,province_name) VALUES (16,'410000','河南省');
INSERT INTO provinces (id,province_id,province_name) VALUES (17,'420000','湖北省');
INSERT INTO provinces (id,province_id,province_name) VALUES (18,'430000','湖南省');
INSERT INTO provinces (id,province_id,province_name) VALUES (19,'440000','广东省');
INSERT INTO provinces (id,province_id,province_name) VALUES (20,'450000','广西壮族自治区');
INSERT INTO provinces (id,province_id,province_name) VALUES (21,'460000','海南省');
INSERT INTO provinces (id,province_id,province_name) VALUES (22,'500000','重庆市');
INSERT INTO provinces (id,province_id,province_name) VALUES (23,'510000','四川省');
INSERT INTO provinces (id,province_id,province_name) VALUES (24,'520000','贵州省');
INSERT INTO provinces (id,province_id,province_name) VALUES (25,'530000','云南省');
INSERT INTO provinces (id,province_id,province_name) VALUES (26,'540000','西藏自治区');
INSERT INTO provinces (id,province_id,province_name) VALUES (27,'610000','陕西省');
INSERT INTO provinces (id,province_id,province_name) VALUES (28,'620000','甘肃省');
INSERT INTO provinces (id,province_id,province_name) VALUES (29,'630000','青海省');
INSERT INTO provinces (id,province_id,province_name) VALUES (30,'640000','宁夏回族自治区');
INSERT INTO provinces (id,province_id,province_name) VALUES (31,'650000','新疆维吾尔自治区');
INSERT INTO provinces (id,province_id,province_name) VALUES (32,'710000','台湾省');
INSERT INTO provinces (id,province_id,province_name) VALUES (33,'810000','香港特别行政区');
INSERT INTO provinces (id,province_id,province_name) VALUES (34,'820000','澳门特别行政区');
";
    }

    public function run()
    {
        DB::table('provinces')->delete();
        $arr = explode(';',$this->sql);
        foreach ($arr as $v) {
            print_r($v."YES");
            if(trim($v)??null){
                DB::insert($v);
            }

        }

    }
}
