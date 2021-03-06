# 1. 老干部帮扶系统-V1.0-API

<!-- TOC -->

- [0. tips](#0-tips)
- [1. 用户](#1-用户)
  - [1.1. 登录](#11-登录)
- [2. 心愿](#2-心愿)
  - [2.1. 心愿列表](#21-心愿列表)
  - [2.2. 发布心愿（获取页面数据）](#22-发布心愿（获取页面数据）)
  - [2.3. 发布心愿（发布）](#23-发布心愿（发布）)
  - [2.4. 获取心愿信息](#24-获取心愿信息)
  - [2.5. 取消心愿](#25-取消心愿)
  - [2.6. 接受心愿](#26-接受心愿)
  - [2.7. 确认完成心愿](#27-确认完成心愿)
- [3. 图片](#3-图片)
  - [3.1 图片上传](#31-图片上传)

<!-- /TOC -->

# 0. tips

- 以下所有url的根均为 http://wish.jblog.info/v1
- code :
  - 0 : 一切正常
  - 1 : 直接将 message 展示给用户
  - 2 : 验证用户无效,跳转至登录页

---

# 1. 用户

## 1.1. 登录

- POST /user/login
- payload :

```json
{
    "account": "账号",
    "password": "密码"
}
```

- return :

```json
{
    "code": 0,
    "message": "",
    "data": null
}
```

---

# 2. 心愿

## 2.1. 心愿列表

- GET /wish/list

- return :

```json
{
    "code": 0,
    "message": "",
    "data": {
        "accepted": [
            {
                "id": "心愿id",
                "time": "发布时间，直接显示",
                "deadline": "截止日期，直接显示",
                "content": "内容，直接显示"
            }
        ],
        "unaccepted": [
            {
                "id": "心愿id",
                "time": "发布时间，直接显示",
                "deadline": "截止日期，直接显示",
                "content": "内容，直接显示"
            }
        ]
    }
}
```

---

## 2.2. 发布心愿（获取页面数据）

- GET /wish/pubPage

- return :

```json
{
    "code": 0,
    "message": "",
    "data": {
        "guy": "联系人",
        "phone": "联系方式"
    }
}
```

---

## 2.3. 发布心愿（发布）

- POST /wish/pub

- payload :

```json
{
    "content": "心愿内容",
    "img": "图片url，通过图片上传方法获取",
    "guy": "联系人",
    "phone": "联系方式",
    "deadline": "截止时间"
}
```

- return :

```json
{
    "code": 0,
    "message": "",
    "data": null
}
```

---

## 2.4. 获取心愿信息

- GET /wish/info?
  - id : 心愿id

- return :

```json
{
    "code": 0,
    "message": "",
    "data": {
        "id": "心愿id",
        "content": "心愿内容",
        "img": "图片url",
        "guy": "联系人",
        "phone": "联系方式",
        "deadline": "截止日期",
        "angel": {
            "guy": "认领人",
            "phone": "联系方式",
            "done": "是否已完成"
        }
    }
}
```

---

## 2.5. 取消心愿

- POST /wish/cancel

- payload :
```json
{
    "id": "心愿id",
    "reason": "取消原因"
}
```

- return :

```json
{
    "code": 0,
    "message": "",
    "data": null
}
```

---

## 2.6. 接受心愿

- POST /wish/accept

- payload :
```json
{
    "id": "心愿id",
    "phone": "联系方式"
}
```

- return :

```json
{
    "code": 0,
    "message": "",
    "data": null
}
```

---

## 2.7. 确认完成心愿

- POST /wish/confirm

- payload :
```json
{
    "id": "心愿id",
    "time": "服务时长",
    "judge": "评价(A,B,C,D)"
}
```

- return :

```json
{
    "code": 0,
    "message": "",
    "data": null
}
```

---

# 3. 图片

## 3.1. 图片上传

- POST /img/upload

- return :

```json
    "code": 0,
    "message": "",
    "data": "图片url"
```