package pl.cms.system.client.model;

import java.util.ArrayList;

import pl.cms.helpers.client.json.JS;

import com.google.gwt.jsonp.client.JsonpRequestBuilder;
import com.google.gwt.user.client.rpc.AsyncCallback;

public class Jsonp extends JsonpRequestBuilder {
	private int delayTime = 3000;
	private String url = "getData.php?";
	ArrayList<String> vars = new ArrayList<String>();
	

	public Jsonp(){
		setTimeout(delayTime);
	}
	
	public void setVars(ArrayList<String> vars) {
		this.vars = vars;
	}
	
	public void addVar(String var){
		this.vars.add(var);
	}
	
	public void request(AsyncCallback<JS> callback) {
		requestObject(getUrl(), callback);
	}
	
	public void request(ArrayList<String> vars, AsyncCallback<JS> callback) {
		setVars(vars);
		request(callback);
	}

	private String getUrl() {
		//String url = "ajax/";
		String u = url;
		for(int i=0;i<vars.size();i++){
			if(i==0){
				u += "p=";
			}
			if(i==1){
				u += "i=";
			}
			u += vars.get(i)+"&";
		}
		return u;
	}


	public void setRequsetType(String string) {
		// TODO Auto-generated method stub
		
	}

	

//	public void request(AsyncCallback<JsonpDataMng> startCallback) {
//		// TODO Auto-generated method stub
//		
//	}

}
