##pms(PEOPLE MANAGE SYSTEM)
### **主要实现功能**：
> - 人员基本信息浏览、查询，包括高级组合条件查询
-	登陆后能够浏览当前库存人员状态
-	按照常用分类浏览职称、学历信息，并进行筛选
-	多用户共同管理，记录修改，阻止越权修改

##各个模块功能分配：
>带 * 表示需要高级权限

###人员基本信息管理 [PEOPLE CONTROLLER]
-	[index] 显示统计信息，人员总数、各级别人员数
-	[addNew] 新进人员基本信息录入
-	[edit] 人员基本信息变更
-	[changeId] 身份证号码修改 *

###学历信息管理 [EDUCATION CONTROLLER]
-	[index] 显示学历总览
-	[addNew] 增加新学历
-	[edit] 修改学历信息
-	[search] 查询个人学历

###人事变动管理 [TRANSFER CONTROLLER]
-	[search] 人员变动记录查询
-	[addNew] 记录人事变动&修改People表Post段内容
-	[edit] 修改人事变动记录

###职称管理 [TITLE CONTROLLER]
-	查询职称情况
-	添加职称获得情况
-	修改职称信息

###部门管理 [DEPARTMENT CONTROLLER]
-	[index] 总览部门情况

###多用户功能实现 [USER CONTROLLER]
-	[checkLevel] 检测当前登录用户权限
-	[login] 用户登录功能
-	[changePwd] 修改用户密码
-	[addNew] 添加新用户 *
-	[changeLevel] 修改用户权限 *

###高级搜索 [ADVSEARCH CONTROLLER]
>	路由绑定到 AdvSearch.php 作为index入口

- 进行组合条件复杂查询
