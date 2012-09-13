package pl.cms.helpers.client.json_test;

import java.util.ArrayList;
import java.util.Date;

import pl.cms.helpers.client.var.Value;

import com.google.gwt.core.client.JavaScriptObject;
import com.google.gwt.event.shared.GwtEvent;
import com.google.gwt.user.client.rpc.AsyncCallback;

public class RequestEntry {
	
	private String name;
	private JavaScriptObject result;
	private Date lastTimeUpdated;
	public enum Status {OK,EMPTY,WAIT}
	private Status resultStatus = Status.EMPTY;
	
	
	public enum Method {GET,POST,JSONP,PUT,HEAD} 
	private Method method = Method.JSONP;
	private GwtEvent event;
	private ArrayList<Value> urlVars= new ArrayList<Value>();
	private int requestCount = 0;
	/*
	 * deprecated
	 */
	private AsyncCallback<JavaScriptObject> asyncCallback;
	
	
	public RequestEntry(){
	}
	
	public RequestEntry(String name){
		this.name = name;
	}

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public JavaScriptObject getResult() {
		return result;
	}

	public void setResult(JavaScriptObject result) {
		this.result = result;
		lastTimeUpdated = new Date();
		requestCount++;
		resultStatus = Status.OK;
	}

	public Date getLastTimeUpdated() {
		return lastTimeUpdated;
	}

	public void setLastTimeUpdated(Date lastTimeUpdated) {
		this.lastTimeUpdated = lastTimeUpdated;
	}

	public int getRequestCount() {
		return requestCount;
	}

	public void setRequestCount(int requestCount) {
		this.requestCount = requestCount;
	}

	public Status getResultStatus() {
		return resultStatus;
	}

	public void setResultStatus(Status resultStatus) {
		this.resultStatus = resultStatus;
	}

	public ArrayList<Value> getUrlVars() {
		return urlVars;
	}

	public void setUrlVars(ArrayList<Value> urlVars) {
		this.urlVars = urlVars;
	}

	public AsyncCallback<JavaScriptObject> getAsyncCallback() {
		return asyncCallback;
	}

	public void setAsyncCallback(AsyncCallback<JavaScriptObject> asyncCallback) {
		this.asyncCallback = asyncCallback;
	}

	public Method getMethod() {
		return method;
	}

	public void setMethod(Method method) {
		this.method = method;
	}

	public GwtEvent getEvent() {
		return event;
	}

	public void setEvent(GwtEvent event) {
		this.event = event;
	}
}
