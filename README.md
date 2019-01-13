## 使用方法
### 1.将setConfig文件夹放至tp框架下的extend目录；

### 2.引用类
```
use setConfig\SetConfig;
```

### 3.实例化
```
$config = new SetConfig();
```

### 4.修改配置
```
$config->setConfig('配置参数','配置值');

```
### 5.修改二级配置
```
$config->setConfig('配置参数.二级参数','配置值');
```
### 6.修改多个配置
```
$config->setConfig('配置参数1,配置参数2,...','配置值1,配置值2,...');
```

## 其他说明
### 返回值
```
pointer---参数下标
config_name---配置参数名
error_code---状态码
msg---说明
```
### 注：
#### 1.配置修改成功后将会覆盖掉原有的config.php文件；
#### 2.新的config.php文件没有配置参数注释；
