# pms(PEOPLE MANAGE SYSTEM)
### **主要实现功能**：
> - 人员基本信息浏览、查询，包括高级组合条件查询
-	登陆后能够浏览当前库存人员状态
-	按照常用分类浏览职称、学历信息，并进行筛选
-	多用户共同管理，记录修改，阻止越权修改

##各个模块功能分配：
>带 * 表示需要高级权限

### 人员基本信息管理 [PEOPLE CONTROLLER]
-	[index] 显示统计信息，人员总数、各级别人员数
-	[addNew] 新进人员基本信息录入
-	[edit] 人员基本信息变更
-	[changeId] 身份证号码修改 *



### 用户控制面板 [USER CONTROLLER]
-	[checkLevel] 检测当前登录用户权限
-	[login] 用户登录功能
-	[changePwd] 修改用户密码
-	[addNew] 添加新用户 *
-	[changeLevel] 修改用户权限 *
-   [departmentM] 管理部门

### 高级搜索 [ADVSEARCH CONTROLLER]
>	Search控制器实现按条件筛选



## 各个模块功能分配  
> ! 表示权限要求,^ 表示保护方法

### Index Controller
- *index*汇总显示系统储存概况
- ^*people* 人员信息总览，总人数、个级别人数
- ^*education* 学历总览，各层次学历人员总数
- ^*title* 职称总览，个级别、专业人数
- ^*department* 部门树，系统部门分类

### Search Controller 
> *路由绑定到search.php*

- *index* 搜索项目，指定模块或信息完成搜索
- *adv* 复杂搜索，组合条件搜索

### Common Controller
- *getSearch* 返回人员/ID搜索结果[AJAX]
- *getRecord* 返回具体项目KEY的记录[AJAX]
- *editRecord* 保存POST指定项目数据[AJAX]
- *delRecord* 删除某条记录[AJAX]
- *getDm* 获得部门编号、名称[AJAX]


### User Controller
- *login* 登录处理
- *checkLevel* 检查用户权限
- *getLeve* 获得用户权限值
- *changePwd* 修改密码
- !!! *changeLevel* 修改用户级别
- !!! *addNew* 添加新用户
