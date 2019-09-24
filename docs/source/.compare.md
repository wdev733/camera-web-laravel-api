---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#Device management API


<!-- START_d7b7b6b6722ea6ba1d333fe121b1b401 -->
## device-api/register
> Example request:

```bash
curl -X POST "http://localhost/device-api/register" \
    -H "Authorization: Bearer {your-token}" \
    -H "Content-Type: application/json" \
    -d '{"mac_address":"quia"}'

```

```javascript
const url = new URL("http://localhost/device-api/register");

let headers = {
    "Authorization": "Bearer {your-token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
}

let body = {
    "mac_address": "quia"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "api_key": "XXXXXXXX"
}
```
> Example response (403):

```json
{
    "message": "IFU with this mac address not found."
}
```

### HTTP Request
`POST device-api/register`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    mac_address | string |  required  | The mac Address of the IFU device.

<!-- END_d7b7b6b6722ea6ba1d333fe121b1b401 -->


