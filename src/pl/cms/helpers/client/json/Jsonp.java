package pl.cms.helpers.client.json;

import java.util.ArrayList;

import com.google.gwt.jsonp.client.JsonpRequestBuilder;
import com.google.gwt.user.client.rpc.AsyncCallback;

public class Jsonp extends JsonpRequestBuilder {
	private int delayTime = 3000;
	private UrlEntry url = new UrlEntry();
	private int uniqueIndex = 0;
	
	Token token = new Token();
	
	public Jsonp(){
		setTimeout(delayTime);
	}
	
	public void addVar(String name, String value){
		if(name==null) name = createUniqueUrlIndex();
		url.addValue(name, value);
	}
	
	public void setVars(ArrayList<String> vars) {
		if(vars==null) return;
		for (int i = 0; i < vars.size(); i++) {
			url.addValue(createUniqueUrlIndex(), vars.get(i));
		}
	}
	
	public void clearUrlVars(){
		url.clearValues();
	}
	
	public void request(AsyncCallback<JS> callback) {
		requestObject(getUrl(), callback);
	}
	
	public void request(ArrayList<String> vars, AsyncCallback<JS> callback) {
		setVars(vars);
		request(callback);
	}

	private String getUrl() {
		return url.getUrl();
	}
	
	public void setToken(Token t){
		this.token = t;
	}
	
	public Token getToken(){
		return token;
	}



	public void setRequsetType(String string) {
		// TODO Auto-generated method stub
		
	}

	private String createUniqueUrlIndex(){
		return "y"+uniqueIndex++;
	}

//	public void request(AsyncCallback<JsonpDataMng> startCallback) {
//		// TODO Auto-generated method stub
//		
//	}

}
