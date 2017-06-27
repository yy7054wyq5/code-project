# tunnel-fan

### 结构说明
```html
.tmp        开发展示样式和页面
dist        生产代码
src         开发代码
--img
--modal     模态框集合
--vendor    库类
index.html 
main.js     主js
main.less   主样式
```
>两个系统公用时序新增页（time-control-add-pro）和详情页（time-control-pro-detail），所以需在展示详情层前重新构建布局<br>
>在时序详情层，包含删除、编辑等操作


### 项目构建
* 1.利用hash值区分系统
* 2.所有模态框单独管理
* 3.插件配置置于页面元素的自定义属性上

### 项目开发
* 开发前，执行命令行语句：npm install（安装所需库类和开发用工具）
* 开发时，执行命令行语句：gulp dev（使用gulp等插件，将js css 模态html自动更新到index.html）

### 发布线上
* gulp clean 清理文件夹
* gulp build 生成线上代码