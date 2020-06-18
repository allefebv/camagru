export function ajaxify(jsonString, callback, route) {
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState === 4 && httpRequest.status !== 200) {
            console.log('error return requete serveur')
            document.write(httpRequest.status)
            return false
        }
        else if (httpRequest.readyState === 4 && httpRequest.status === 200) {
            var httpResponse = httpRequest.response
            if (httpResponse) {
                var obj = JSON.parse(httpRequest.response)
                if (obj) {
                    callback(obj)
                }
            }
        }
    }
    httpRequest.open('POST', route, true)
    httpRequest.setRequestHeader('Content-Type', 'multipart/form-data')
    httpRequest.send(jsonString)
}