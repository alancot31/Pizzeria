package com.sio.mavenprojectwebservice.tools;

import jakarta.ws.rs.client.Client;
import jakarta.ws.rs.client.ClientBuilder;
import jakarta.ws.rs.client.Entity;
import jakarta.ws.rs.client.Invocation;
import jakarta.ws.rs.client.WebTarget;
import jakarta.ws.rs.core.MediaType;
import jakarta.ws.rs.core.Response;
import org.json.simple.JSONArray;
import org.json.simple.JSONObject;
import org.json.simple.JSONValue;


public class RequestToHistory{
    private static String nomDossier ="pizzeriaGroup4";
    private static String urlDossier= "http://localhost/"+nomDossier+"/server/Historique/";
    private static String url= "http://localhost/"+nomDossier+"/server/Historique";
/* REQUEST Historique */
    public static JSONObject getHistoriquebyid(int id) {
        Client client = ClientBuilder.newClient();
        WebTarget webTarget = client.target(urlDossier+id);
        Invocation.Builder invocationBuilder = webTarget.request(MediaType.APPLICATION_JSON_PATCH_JSON_TYPE);
        invocationBuilder.header("some-header", "true");
        Response response = invocationBuilder.get();
        String rep = response.readEntity(String.class);
        Object val=JSONValue.parse(rep);  
        JSONObject jsonObject = (JSONObject) val; 
        return jsonObject;
    }
    public static JSONArray getListHistorique(){
                 Client client = ClientBuilder.newClient();
               WebTarget webTarget = client.target(url);
                Invocation.Builder invocationBuilder =
                webTarget.request(MediaType.APPLICATION_JSON_PATCH_JSON_TYPE);
                invocationBuilder.header("some-header", "true");
                Response response = invocationBuilder.get();
                String rep = response.readEntity(String.class);
                Object val=JSONValue.parse(rep);  
                JSONArray jsonObject = (JSONArray) val; 
        return jsonObject; 
    }
    public static void postArticle(JSONObject obj){
        Client client = ClientBuilder.newClient();
        WebTarget webTarget = client.target(url);
        webTarget.request(MediaType.TEXT_PLAIN).post(Entity.entity(obj.toJSONString(), MediaType.TEXT_PLAIN));
    }
}
