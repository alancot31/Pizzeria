/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
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

/**
 *
 * @author Administrateur
 */
public class RequestServer {
        private static String nomDossier ="pizzeriaGroup4";
        private static String articleUrldossier= "http://localhost/"+nomDossier+"/server/Article/";
        private static String articleUrl= "http://localhost/"+nomDossier+"/server/Article";
    /* REQUEST ARTICLE */
    public static JSONObject getArticlebyid(int id) {
          Client client = ClientBuilder.newClient();
               WebTarget webTarget = client.target(articleUrldossier+id);
                Invocation.Builder invocationBuilder =
                webTarget.request(MediaType.APPLICATION_JSON_PATCH_JSON_TYPE);
                invocationBuilder.header("some-header", "true");
                Response response = invocationBuilder.get();
                String rep = response.readEntity(String.class);
                Object val=JSONValue.parse(rep);  
                JSONObject jsonObject = (JSONObject) val; 
        return jsonObject;    
    }
    public static JSONArray  getListArticle(){
            JSONArray list = new JSONArray();
            boolean ok = true;
            int cpt = 1;
            while(ok ==true){
                list.add(getArticlebyid(cpt));
                if(getArticlebyid(cpt) == null){
                    ok = false;
                }
                cpt++;
                
            }
            list.remove(list.size()-1);
        
            return list;
    }
    public static void postArticle(JSONObject obj){
            Client client = ClientBuilder.newClient();
         WebTarget webTarget = client.target(articleUrl);
         webTarget.request(MediaType.TEXT_PLAIN)
                .post(Entity.entity(obj.toJSONString(), MediaType.TEXT_PLAIN));
        }
    public static void deleteArticle(int id){
            Client client = ClientBuilder.newClient();
         WebTarget webTarget = client.target(articleUrldossier+id);
         webTarget.request(MediaType.TEXT_PLAIN)
                .delete();
        }
    public static void updateArticle(JSONObject obj){
            Client client = ClientBuilder.newClient();
         WebTarget webTarget = client.target(articleUrl);
         webTarget.request(MediaType.TEXT_PLAIN)
                .put(Entity.entity(obj.toJSONString(), MediaType.TEXT_PLAIN));
         
        }  

    /////////////////TABLES RESTAURANTS//////////////////////////////////////
    public static JSONObject getTablebyid(int cpt) {
        Client client = ClientBuilder.newClient();
               WebTarget webTarget = client.target("http://localhost/pizzeriaGroup4/server/TableRestaurant/"+cpt);
                Invocation.Builder invocationBuilder =
                webTarget.request(MediaType.APPLICATION_JSON_PATCH_JSON_TYPE);
                invocationBuilder.header("some-header", "true");
                Response response = invocationBuilder.get();
                String rep = response.readEntity(String.class);
                Object val=JSONValue.parse(rep);  
                JSONObject jsonObject = (JSONObject) val; 
        return jsonObject;    
    }
        public static void deleteTable(int id){
            Client client = ClientBuilder.newClient();
         WebTarget webTarget = client.target("http://localhost/pizzeriaGroup4/server/TableRestaurant/"+id);
         webTarget.request(MediaType.TEXT_PLAIN)
                .delete();
        }
     public static void updateTable(JSONObject obj){
            Client client = ClientBuilder.newClient();
         WebTarget webTarget = client.target("http://localhost/pizzeriaGroup4/server/TableRestaurant");
         webTarget.request(MediaType.TEXT_PLAIN)
                .put(Entity.entity(obj.toJSONString(), MediaType.TEXT_PLAIN));
         
        }  
         public static void postTable(JSONObject obj){
            Client client = ClientBuilder.newClient();
         WebTarget webTarget = client.target("http://localhost/pizzeriaGroup4/server/TableRestaurant");
         webTarget.request(MediaType.TEXT_PLAIN)
                .post(Entity.entity(obj.toJSONString(), MediaType.TEXT_PLAIN));
         
        } 
    public static JSONArray getListTable() {
       Client client = ClientBuilder.newClient();
               WebTarget webTarget = client.target("http://localhost/pizzeriaGroup4/server/TableRestaurant");
                Invocation.Builder invocationBuilder =
                webTarget.request(MediaType.APPLICATION_JSON_PATCH_JSON_TYPE);
                invocationBuilder.header("some-header", "true");
                Response response = invocationBuilder.get();
                String rep = response.readEntity(String.class);
                Object val=JSONValue.parse(rep);  
                JSONArray jsonObject = (JSONArray) val; 
        return jsonObject; 
    }
//////////////////////////////COMMANDE//////////////////////////////////////////
    
    public static JSONObject getCommandebyid(int idcommande){
         Client client = ClientBuilder.newClient();
               WebTarget webTarget = client.target("http://localhost/pizzeriaGroup4/server/Commande/"+idcommande);
                     Invocation.Builder invocationBuilder =
                webTarget.request(MediaType.APPLICATION_JSON_PATCH_JSON_TYPE);
                invocationBuilder.header("some-header", "true");
                Response response = invocationBuilder.get();
                String rep = response.readEntity(String.class);
                Object val=JSONValue.parse(rep);  
                JSONObject jsonObject = (JSONObject) val; 
        return jsonObject;  
    }
    public static JSONArray getListCommande(){
           Client client = ClientBuilder.newClient();
               WebTarget webTarget = client.target("http://localhost/pizzeriaGroup4/server/Commande");
                Invocation.Builder invocationBuilder =
                webTarget.request(MediaType.APPLICATION_JSON_PATCH_JSON_TYPE);
                invocationBuilder.header("some-header", "true");
                Response response = invocationBuilder.get();
                String rep = response.readEntity(String.class);
                Object val=JSONValue.parse(rep);  
                JSONArray jsonObject = (JSONArray) val; 
        return jsonObject;    
    }
    public static void updateCommande(JSONObject obj){
            Client client = ClientBuilder.newClient();
         WebTarget webTarget = client.target("http://localhost/pizzeriaGroup4/server/Commande");
         webTarget.request(MediaType.TEXT_PLAIN)
                .put(Entity.entity(obj.toJSONString(), MediaType.TEXT_PLAIN));
         
        }  
    public static void postCommande(JSONObject obj){
            Client client = ClientBuilder.newClient();
         WebTarget webTarget = client.target("http://localhost/pizzeriaGroup4/server/Commande");
         webTarget.request(MediaType.TEXT_PLAIN)
                .post(Entity.entity(obj.toJSONString(), MediaType.TEXT_PLAIN));
        }
    

////////////////////////////HISTORY/////////////////////////////////////////////
 public static void postHistory(JSONObject obj){
            Client client = ClientBuilder.newClient();
         WebTarget webTarget = client.target("http://localhost/pizzeriaGroup4/server/Historique");
         webTarget.request(MediaType.TEXT_PLAIN)
                .post(Entity.entity(obj.toJSONString(), MediaType.TEXT_PLAIN));
        }

}
