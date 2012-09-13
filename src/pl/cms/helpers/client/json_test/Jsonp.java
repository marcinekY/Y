package pl.cms.helpers.client.json_test;

import java.util.ArrayList;

import pl.cms.helpers.client.json.UrlEntry;
import pl.cms.helpers.client.var.Value;

import com.google.gwt.core.client.JavaScriptObject;
import com.google.gwt.jsonp.client.JsonpRequestBuilder;
import com.google.gwt.user.client.Event;
import com.google.gwt.user.client.rpc.AsyncCallback;



public class Jsonp extends JsonpRequestBuilder {
	private int delayTime = 3000;
	private int requestCount = 0;
	
	private UrlEntry url = new UrlEntry();
	private ArrayList<RequestEntry> requests = new ArrayList<RequestEntry>();
	
//	ArrayList<String> vars = new ArrayList<String>();


	public Jsonp(){
		setTimeout(delayTime);
		
	}
	
	private RequestEntry getNewRequest(String name){
		RequestEntry r = new RequestEntry(name);
		r.setAsyncCallback(createDefaultCallback());
		return r;
	}
	
	public AsyncCallback<JavaScriptObject> createDefaultCallback(){
		AsyncCallback<JavaScriptObject> ac = new AsyncCallback<JavaScriptObject>() {
			@Override
			public void onSuccess(JavaScriptObject result) {
				
			}
			@Override
			public void onFailure(Throwable caught) {
			}
		};
		return ac;
	}
	
	public void request(String name, Event event, UrlEntry url) {
		RequestEntry r = getRequest(name);
		if(r==null) {
			r = new RequestEntry(name);
		}
		r.set
	}

	
	public void request(AsyncCallback<JavaScriptObject> callback) {
		requestObject(getUrl(), callback);
	}
	
	public void request(ArrayList<Value> vars, AsyncCallback<JavaScriptObject> callback) {
		url.setVars(vars);
		request(callback);
	}
	
	private String getUrl() {
		//String url = "ajax/";
		return url.getUrl();
	}

//	private String getUrl() {
//		//String url = "ajax/";
//		String u = url;
//		for(int i=0;i<vars.size();i++){
//			if(i==0){
//				u += "p=";
//			}
//			if(i==1){
//				u += "i=";
//			}
//			u += vars.get(i)+"&";
//		}
//		return u;
//	}
	
	public RequestEntry getRequest(String name){
		RequestEntry re = null;
		for (int i = 0; i < requests.size(); i++) {
			if(requests.get(i).getName().equals(name)){
				re = requests.get(i);
			}
		}
//		if(jso==null){
//			
//		}
		return re;
	}




	public int getDelayTime() {
		return delayTime;
	}

	public void setDelayTime(int delayTime) {
		this.delayTime = delayTime;
	}

	public int getRequestCount() {
		return requestCount;
	}

	public void setRequestCount(int requestCount) {
		this.requestCount = requestCount;
	}

	public ArrayList<RequestEntry> getRequests() {
		return requests;
	}

	public void setRequests(ArrayList<RequestEntry> requests) {
		this.requests = requests;
	}




	

//	public void request(AsyncCallback<JsonpDataMng> startCallback) {
//		// TODO Auto-generated method stub
//		
//	}

}
