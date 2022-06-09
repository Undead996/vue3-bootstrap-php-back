import { ClientJS } from 'clientjs';

export default class UseClientJs extends ClientJS{
	constructor() {
		super();
	}

	getRetailFingerptint() {
		this.fingerPrint = {
			'userAgent': this.getUserAgent(),
			'device': this.getDevice(),
			'CPU': this.getCPU(),
			'screen': this.getScreenPrint(),
			'plugins': this.getPlugins(),
			'fonts': this.getFonts(),
			'timeZone': this.getTimeZone(),
			'language': this.getLanguage(),
			'canvasPint': this.getCanvasPrint()
        };
		return JSON.stringify(this.fingerPrint);
	}
}