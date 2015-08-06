##pms   `PEOPLE MANAGE SYSTEM`
### **主要实现功能**：
> - 人员基本信息浏览、查询，包括高级组合条件查询

-   登陆后能够浏览当前库存人员状态
-   登陆后能够浏览当前库存人员状态
-   按照常用分类浏览职称、学历信息，并进行筛选
-   多用户共同管理，记录修改，阻止越权修改

##各个模块功能分配  
> ! 表示权限要求

### Index Controller
- *index*汇总显示系统储存概况
- *people* 人员信息总览，总人数、个级别人数
- *education* 学历总览，各层次学历人员总数
- *title* 职称总览，个级别、专业人数
- *department* 部门树，系统部门分类


### Search Controller 
> *路由绑定到search.php*

- *index* 搜索项目，指定模块或信息完成搜索
- *adv* 复杂搜索，组合条件搜索

###! Edit Controller
- *index* 选择要修改的人后选择修改项目进行跳转
- *baseinfo* 修改people表中数据
- *education* 列出、修改学历信息
- *title* 列出、修改职称信息
- *transfer* 列出、修改调动信息
- !! *changeId* 管理员可见，修改身份证号码，联动各个表

###! AddNew Controller
- *index* 选择人员后添加项目或跳转添加人员
- *baseinfo* 修改people表中数据
- *education* 列出、修改学历信息
- *title* 列出、修改职称信息
- *transfer* 列出、修改调动信息

###! Del Controller
- *index* 选择人员后删除项目或跳转删除人员
- !! *baseinfo* 删除people表中数据
- ! *education* 删除学历信息
- ! *title* 删除职称信息
- ! *transfer* 删除调动信息

###Common Controller
- *people* 返回人员基本信息
- *education* 返回学历信息
- *title* 返回职称信息
- *transfer* 返回调动信息

### User Controller
- *login* 登录处理
- *changePwd* 修改密码
- !!! *changeLevel* 修改用户级别
- !!! *addNew* 添加新用户


> OLD VERSION CONTROLLERS
##pms(PEOPLE MANAGE SYSTEM)
### **主要实现功能**：
- 人员基本信息浏览、查询，包括高级组合条件查询
- 登陆后能够浏览当前库存人员状态
- 按照常用分类浏览职称、学历信息，并进行筛选
- 多用户共同管理，记录修改，阻止越权修改
##各个模块功能分配 `带 * 表示需要高级权限`：
### [INDEX CONTROLLER]
- [index]汇总显示系统储存概况
 - [people] 人员信息总览，总人数、个级别人数
 - [department] 部门树，系统部门分类
 - [title] 职称总览，个级别、专业人数
 - [education] 学历总览，各层次学历人员总数
###人员基本信息管理 [PEOPLE CONTROLLER]
- [index] 显示统计信息，人员总数、各级别人员数
-   [changeId] 身份证号码修改 *
###学历信息管理 [EDUCATION CONTROLLER]
-   [index] 显示学历总览
-   [search] 查询个人学历
###人事变动管理 [TRANSFER CONTROLLER]
-   [search] 人员变动记录查询
###职称管理 [TITLE CONTROLLER]
- [index] 职称个级别、专业人数总览
-   查询职称情况
###部门管理 [DEPARTMENT CONTROLLER]
-   [index] 总览部门情况
###多用户功能实现 [USER CONTROLLER]
-   [checkLevel] 检测当前登录用户权限
-   [login] 用户登录功能
-   [changePwd] 修改用户密码
-   [addNew] 添加新用户 *
-   [changeLevel] 修改用户权限 *
###高级搜索 [ADVSEARCH CONTROLLER]
>   路由绑定到 AdvSearch.php 作为index入口
- 进行组合条件复杂查询