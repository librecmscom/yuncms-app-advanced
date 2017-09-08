# API 开发手册

通过一个简单而强大的API访问 YUNCMS 。

![Api](./images/api.gif)

## 接口

Documentation is at [http://docs.yuncms.net/](http://docs.yuncms.net/).

[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/35258eef15a780e63da5)


## 快速入门

YUNCMS 提供了一整套用来简化实现 RESTful 风格的 Web Service 服务的 API。 特别是，YUNCMS 支持以下关于 RESTful 风格的 API：

* 支持 Active Record 类的通用API的快速原型
* 涉及的响应格式（在默认情况下支持 JSON 和 XML)
* 支持可选输出字段的定制对象序列化
* 适当的格式的数据采集和验证错误
* 支持 [HATEOAS](http://en.wikipedia.org/wiki/HATEOAS)
* 有适当HTTP动词检查的高效的路由
* 内置`OPTIONS`和`HEAD`动词的支持
* 认证和授权
* 数据缓存和HTTP缓存
* 速率限制

## 授权机制

YUNCMS 接口的调用，如发直播、关注等，都是需要获取用户身份认证的。目前 YUNCMS 开放平台用户身份鉴权主要采用的是`OAuth2.0`。
另外，为了方便开发者开发、测试自己的应用，我们还提供了 `Client Credentials` 的身份鉴权方式，但 `Client Credentials` 仅适用于应用所属的开发者自己调用接口。

## OAuth2.0 概述

`OAuth2.0` 较1.0相比，整个授权验证流程更简单更安全，也是未来最主要的用户身份验证和授权方式。

关于 `OAuth2.0` 协议的授权流程可以参考下面的流程图，其中 `Client` 指第三方应用，`Resource Owner` 指用户，`Authorization Server` 是我们的授权服务器，`Resource Server` 是API服务器。

![Api](./images/oAuth2_01.gif)

开发者可以先浏览 `OAuth2.0` 的接口文档，熟悉 `OAuth2.0` 的接口及参数的含义，然后我们根据应用场景各自说明如何使用 `OAuth2.0` 。

## 请求验证

所有API请求都需要通过个人访问令牌进行身份验证。
如果认证信息无效或省略，将显示错误消息返回状态代码 `401`:

```json
{
    "name": "invalid_request",
    "message": "提供的访问令牌无效。",
    "code": 0
}
```

## 基本使用

有效的API请求示例:

```shell
curl --header "Authorization:Bearer P-S4Q3zahfKZq9WbB3XBo9z-31t84R0l" "http://api.yuncms.net/v1/users"
```

## 内容协商

如果一个 API 请求中包含以下 header，`Accept: application/json` 将会得到JSON格式的响应。如果一个 API 请求中包含以下 header，`Accept: application/xml`
将会得到XML格式的响应。

## 状态代码

API设计为根据上下文返回不同的状态代码。 这样，如果请求导致错误，调用者能够得到
洞察什么错误。

下表显示了API请求的可能返回代码。

| 返回值 | 描述 |
| ------------- | ----------- |
| `200` | OK。一切正常。 |
| `201` | 响应 `POST` 请求时成功创建一个资源。`Location` header 包含的URL指向新创建的资源。 |
| `204` | 该请求被成功处理，响应不包含正文内容 (类似 `DELETE` 请求)。 |
| `304` | 资源没有被修改。可以使用缓存的版本。 |
| `400` | 错误的请求。可能通过用户方面的多种原因引起的，例如在请求体内有无效的数据或无效的操作参数，等等。 |
| `401` | 验证失败，需要有效的用户令牌。 |
| `403` | 已经经过身份验证的用户不允许访问指定的 API 末端。 |
| `404` | 所请求的资源不存在。 |
| `405` | 不被允许的方法。 |
| `415` | 不支持的媒体类型。 所请求的内容类型或版本号是无效的。 |
| `422` | 数据验证失败 (例如，响应一个 `POST` 请求)。 请检查响应体内详细的错误消息。 |
| `429` | 请求过多。 由于限速请求被拒绝。 |
| `500` | 内部服务器错误。 这可能是由于内部程序错误引起的。 |

## 分页

有时，返回的结果将跨越多个页面。 列出资源时，您可以传递以下参数:

| 参数 | 描述 |
| --------- | ----------- |
| `page`    | 页码 (默认: `1`) |
| `per_page`| 每页列出的项目数 (默认: `20`, 最大: `100`) |

下面的事例中, 我们每个页面列出 50 条用户。

```shell
curl --header "Authorization:Bearer P-S4Q3zahfKZq9WbB3XBo9z-31t84R0l" "http://api.yuncms.net/v1/users?per_page=50"
```

### 分页链接 header

[Link headers](http://www.w3.org/wiki/LinkHeader) 与每个响应一起发送回来。
 它们的 `rel` 设置为 prev/next/first/last，并包含相关的URL。 
 请使用这些链接，而不是生成您自己的链接。

在下面的Curl事例总, 我们限制每页3项 (`per_page=3`) 并且请求第二页 (`page=2`) 的 用户 列表:

```shell
curl --header "Authorization:Bearer P-S4Q3zahfKZq9WbB3XBo9z-31t84R0l" "http://api.yuncms.net/v1/users?per_page=3&page=2"
```

然后响应将是:

```
HTTP/1.1 200 OK
Cache-Control: no-cache
Content-Length: 1103
Content-Type: application/json
Date: Mon, 18 Jan 2016 09:43:18 GMT
Link: <http://api.yuncms.net/v1/users?per_page=3&page=2>; rel=self, <http://api.yuncms.net/v1/users?per_page=3&page=1>; rel=first, <http://api.yuncms.net/v1/users?per_page=3&page=1>; rel=prev, <http://api.yuncms.net/v1/users?per_page=3&page=3>; rel=next, <http://api.yuncms.net/v1/users?per_page=3&page=10>; rel=last
Status: 200 OK
Vary: Origin
X-Pagination-Current-Page: 2
X-Pagination-Page-Count: 10
X-Pagination-Per-Page: 20
X-Pagination-Total-Count: 186
X-Rate-Limit-Limit: 10
X-Rate-Limit-Remaining: 9
X-Rate-Limit-Reset: 0
```

### 其他分页 Header

响应还会发送其他分页标头.

| Header | 描述 |
| ------ | ----------- |
| `Link`       | 允许客户端一页一页遍历资源的导航链接集合。 |
| `X-Pagination-Total-Count`       | 资源所有数量。 |
| `X-Pagination-Page-Count` | 页数。 |
| `X-Pagination-Per-Page`    | 每页资源数量。 |
| `X-Pagination-Current-Page`        | 当前页(从1开始)。 |
| `X-Rate-Limit-Limit`   | 同一个时间段所允许的请求的最大数目。 |
| `X-Rate-Limit-Remaining`   | 在当前时间段内剩余的请求的数量。 |
| `X-Rate-Limit-Reset`   | 为了得到最大请求数所等待的秒数。 |

## 结果排序

如果一个 API 请求中包含以下 Query Params，`sort=:field` 将会得到按照 `field` 正排的结果列表。如果在 `field` 前面加上 `-` 符号，你将得到一个倒排的结果。

下面的事例中, 我们每个页面列出 50 条用户并且按照用户ID倒排。

```shell
curl --header "Authorization:Bearer P-S4Q3zahfKZq9WbB3XBo9z-31t84R0l" "http://api.yuncms.net/v1/users?per_page=50&sort=-id"
```

## 未知路由

当您尝试访问不存在的API网址时，您将收到 `404 Not Found` 。

```
HTTP/1.1 404 Not Found
Content-Type: application/json
{
    "name": "Not Found",
    "message": "Object not found: 1213",
    "code": 0
}
```