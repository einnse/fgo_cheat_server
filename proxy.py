from mitmproxy import http
import urllib

def load(load):
    load.add_option("block_global", bool, False, "disable block_global")
    #load.add_option("mode", str, "socks5", "set proxy mode")

def request(flow: http.HTTPFlow) -> None:
    if flow.request.pretty_host.find("-s2-bili-fate.bilibiligame.net") > -1 :
        if flow.request.url.find("ac.php") > -1 :
            query_key = flow.request.urlencoded_form["key"]
            if query_key == "battleresult" :
                body_bytes = flow.request.content
                body_str = str(body_bytes, encoding="utf-8")
                headers={
                    "Content-Type":"application/x-www-form-urlencoded"
                }
                data={
                    "requestData":body_str
                }
                data=urllib.parse.urlencode(data).encode("utf-8")
                url = "http://127.0.0.1/BattleCancel.php"
                req = urllib.request.Request(url, headers=headers, data=data, method="POST")
                res = urllib.request.urlopen(req).read()
                flow.request.content = res

def response(flow: http.HTTPFlow) -> None:
    if flow.request.url.find("ac.php") > -1 :
        query_key = flow.request.urlencoded_form["key"]
        if query_key == "battlesetup" or query_key == "battleresume" :
            body_bytes = flow.response.content
            body_str = str(body_bytes, encoding="utf-8")
            headers={
                "Content-Type":"application/x-www-form-urlencoded"
            }
            data={
                "responseData":body_str
            }
            data=urllib.parse.urlencode(data).encode("utf-8")
            url = "http://127.0.0.1/BattleSetup.php"
            req = urllib.request.Request(url, headers=headers, data=data, method="POST")
            res = urllib.request.urlopen(req).read()
            flow.response.content = res
