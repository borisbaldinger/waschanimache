/********************************
Pulse Cosmic UI plugin
*********************************/

(function(P) {

	P.plugin.koken_pulse_cosmic = function(options) {

		options = $.extend({
			koken_pulse_cosmic_style: 'black',
			koken_pulse_cosmic_position: 'top',
			koken_pulse_cosmic_controls: true,
			koken_pulse_cosmic_fullscreen: true,
			koken_pulse_cosmic_hover: false
		}, options);

		var self = this,
			nextActive = true,
			prevActive = true,
			schemes = {
				black: {
					background: '#000',
					text: '#999',
					buttonInactive: "#333",
					titleText: '#fff',
					borderColor: '#333',
					buttons: {
						next: 'data:image/gif;base64,R0lGODlhMAAwAIABAAAAAP///yH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjAxODAxMTc0MDcyMDY4MTFBRDU3RTExMEVEMjMzODQ2IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkUyMzY5NDcwMzhCNTExRTI5QkYwQTAzMDhDRDUwMDhGIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkUyMzY5NDZGMzhCNTExRTI5QkYwQTAzMDhDRDUwMDhGIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzUgTWFjaW50b3NoIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MDE4MDExNzQwNzIwNjgxMUFENTdFMTEwRUQyMzM4NDYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MDE4MDExNzQwNzIwNjgxMUFENTdFMTEwRUQyMzM4NDYiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4B//79/Pv6+fj39vX08/Lx8O/u7ezr6uno5+bl5OPi4eDf3t3c29rZ2NfW1dTT0tHQz87NzMvKycjHxsXEw8LBwL++vby7urm4t7a1tLOysbCvrq2sq6qpqKempaSjoqGgn56dnJuamZiXlpWUk5KRkI+OjYyLiomIh4aFhIOCgYB/fn18e3p5eHd2dXRzcnFwb25tbGtqaWhnZmVkY2JhYF9eXVxbWllYV1ZVVFNSUVBPTk1MS0pJSEdGRURDQkFAPz49PDs6OTg3NjU0MzIxMC8uLSwrKikoJyYlJCMiISAfHh0cGxoZGBcWFRQTEhEQDw4NDAsKCQgHBgUEAwIBAAAh+QQBAAABACwAAAAAMAAwAAACRISPqcvtD6OctNqLs968+w+G4kiW5omm6spSQbu8cCLPR20DuL3PPfxbBVXDVBF1PCVNy1IzB41Kp9Sq9YrNarfcLqAAADs=',
						prev: 'data:image/gif;base64,R0lGODlhMAAwAIABAAAAAP///yH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjAxODAxMTc0MDcyMDY4MTFBRDU3RTExMEVEMjMzODQ2IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkUyMzY5NDc0MzhCNTExRTI5QkYwQTAzMDhDRDUwMDhGIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkUyMzY5NDczMzhCNTExRTI5QkYwQTAzMDhDRDUwMDhGIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzUgTWFjaW50b3NoIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MDE4MDExNzQwNzIwNjgxMUFENTdFMTEwRUQyMzM4NDYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MDE4MDExNzQwNzIwNjgxMUFENTdFMTEwRUQyMzM4NDYiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4B//79/Pv6+fj39vX08/Lx8O/u7ezr6uno5+bl5OPi4eDf3t3c29rZ2NfW1dTT0tHQz87NzMvKycjHxsXEw8LBwL++vby7urm4t7a1tLOysbCvrq2sq6qpqKempaSjoqGgn56dnJuamZiXlpWUk5KRkI+OjYyLiomIh4aFhIOCgYB/fn18e3p5eHd2dXRzcnFwb25tbGtqaWhnZmVkY2JhYF9eXVxbWllYV1ZVVFNSUVBPTk1MS0pJSEdGRURDQkFAPz49PDs6OTg3NjU0MzIxMC8uLSwrKikoJyYlJCMiISAfHh0cGxoZGBcWFRQTEhEQDw4NDAsKCQgHBgUEAwIBAAAh+QQBAAABACwAAAAAMAAwAAACQoSPqcvtD6OctNqLs968+w+G4kiW5omm6spqQZu88CHPQD3jsN7yrN+zIYA/Ic1oIK6UKibyCY1Kp9Sq9YrNarehAgA7',
						fs: 'data:image/gif;base64,R0lGODlhMAAwAIABAAAAAP///yH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjAxODAxMTc0MDcyMDY4MTFBRDU3RTExMEVEMjMzODQ2IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjMyNDMxOTMzMzhCRDExRTI5QkYwQTAzMDhDRDUwMDhGIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjMyNDMxOTMyMzhCRDExRTI5QkYwQTAzMDhDRDUwMDhGIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzUgTWFjaW50b3NoIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MDE4MDExNzQwNzIwNjgxMUFENTdFMTEwRUQyMzM4NDYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MDE4MDExNzQwNzIwNjgxMUFENTdFMTEwRUQyMzM4NDYiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4B//79/Pv6+fj39vX08/Lx8O/u7ezr6uno5+bl5OPi4eDf3t3c29rZ2NfW1dTT0tHQz87NzMvKycjHxsXEw8LBwL++vby7urm4t7a1tLOysbCvrq2sq6qpqKempaSjoqGgn56dnJuamZiXlpWUk5KRkI+OjYyLiomIh4aFhIOCgYB/fn18e3p5eHd2dXRzcnFwb25tbGtqaWhnZmVkY2JhYF9eXVxbWllYV1ZVVFNSUVBPTk1MS0pJSEdGRURDQkFAPz49PDs6OTg3NjU0MzIxMC8uLSwrKikoJyYlJCMiISAfHh0cGxoZGBcWFRQTEhEQDw4NDAsKCQgHBgUEAwIBAAAh+QQBAAABACwAAAAAMAAwAAACWoSPqcvtD6OctNqLs968+w+G4kiW5omm6goErvu8sBdcNW1/d7VzuwyUHXq6YPBkPJqSQCTz5XwSRdJZ6Fcd6nI4yzTzhYRtQkeThU6r1+y2+w2Py+f0uj1TAAA7',
						ns: 'data:image/gif;base64,R0lGODlhMAAwAIABAAAAAP///yH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjAxODAxMTc0MDcyMDY4MTFBRDU3RTExMEVEMjMzODQ2IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjBFRkJGMjE0M0Q4OTExRTI5RTIzREZENTNFODkxQkIwIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjBFRkJGMjEzM0Q4OTExRTI5RTIzREZENTNFODkxQkIwIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzUgTWFjaW50b3NoIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MDE4MDExNzQwNzIwNjgxMTk2QTZCRDJCOEUyRDE4Q0MiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MDE4MDExNzQwNzIwNjgxMUFENTdFMTEwRUQyMzM4NDYiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4B//79/Pv6+fj39vX08/Lx8O/u7ezr6uno5+bl5OPi4eDf3t3c29rZ2NfW1dTT0tHQz87NzMvKycjHxsXEw8LBwL++vby7urm4t7a1tLOysbCvrq2sq6qpqKempaSjoqGgn56dnJuamZiXlpWUk5KRkI+OjYyLiomIh4aFhIOCgYB/fn18e3p5eHd2dXRzcnFwb25tbGtqaWhnZmVkY2JhYF9eXVxbWllYV1ZVVFNSUVBPTk1MS0pJSEdGRURDQkFAPz49PDs6OTg3NjU0MzIxMC8uLSwrKikoJyYlJCMiISAfHh0cGxoZGBcWFRQTEhEQDw4NDAsKCQgHBgUEAwIBAAAh+QQBAAABACwAAAAAMAAwAAACc4SPqcvtD6OctNqLs968+w+G4kiW5ommYMC27gu7G6vEdHJn+WEHta+59WyG3UU4hBWBOmBSCTBakM/WclZNYrO9LTfm/b6wS+416Pyem+XsGkN1R5lwenuMs0/13XxYbKUiOEhYaHiImKi4yNjo+Ah5UAAAOw==',
						background: '#fff',
						hover: '#fff'
					}
				},
				white: {
					background: '#fff',
					text: '#666',
					buttonInactive: "#ccc",
					titleText: '#000',
					borderColor: '#ccc',
					buttons: {
						next: 'data:image/gif;base64,R0lGODlhMAAwAIABAP///wAAACH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjAxODAxMTc0MDcyMDY4MTFBRDU3RTExMEVEMjMzODQ2IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjMyNDMxOTM3MzhCRDExRTI5QkYwQTAzMDhDRDUwMDhGIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjMyNDMxOTM2MzhCRDExRTI5QkYwQTAzMDhDRDUwMDhGIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzUgTWFjaW50b3NoIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MDI4MDExNzQwNzIwNjgxMUFENTdFMTEwRUQyMzM4NDYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MDE4MDExNzQwNzIwNjgxMUFENTdFMTEwRUQyMzM4NDYiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4B//79/Pv6+fj39vX08/Lx8O/u7ezr6uno5+bl5OPi4eDf3t3c29rZ2NfW1dTT0tHQz87NzMvKycjHxsXEw8LBwL++vby7urm4t7a1tLOysbCvrq2sq6qpqKempaSjoqGgn56dnJuamZiXlpWUk5KRkI+OjYyLiomIh4aFhIOCgYB/fn18e3p5eHd2dXRzcnFwb25tbGtqaWhnZmVkY2JhYF9eXVxbWllYV1ZVVFNSUVBPTk1MS0pJSEdGRURDQkFAPz49PDs6OTg3NjU0MzIxMC8uLSwrKikoJyYlJCMiISAfHh0cGxoZGBcWFRQTEhEQDw4NDAsKCQgHBgUEAwIBAAAh+QQBAAABACwAAAAAMAAwAAACRISPqcvtD6OctNqLs968+w+G4kiW5omm6spSQbu8cCLPR20DuL3PPfxbBVXDVBF1PCVNy1IzB41Kp9Sq9YrNarfcLqAAADs=',
						prev: 'data:image/gif;base64,R0lGODlhMAAwAIABAP///wAAACH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjAxODAxMTc0MDcyMDY4MTFBRDU3RTExMEVEMjMzODQ2IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjVDQUI3RjlDMzhDMTExRTI5QkYwQTAzMDhDRDUwMDhGIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjVDQUI3RjlCMzhDMTExRTI5QkYwQTAzMDhDRDUwMDhGIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzUgTWFjaW50b3NoIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MDI4MDExNzQwNzIwNjgxMUFENTdFMTEwRUQyMzM4NDYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MDE4MDExNzQwNzIwNjgxMUFENTdFMTEwRUQyMzM4NDYiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4B//79/Pv6+fj39vX08/Lx8O/u7ezr6uno5+bl5OPi4eDf3t3c29rZ2NfW1dTT0tHQz87NzMvKycjHxsXEw8LBwL++vby7urm4t7a1tLOysbCvrq2sq6qpqKempaSjoqGgn56dnJuamZiXlpWUk5KRkI+OjYyLiomIh4aFhIOCgYB/fn18e3p5eHd2dXRzcnFwb25tbGtqaWhnZmVkY2JhYF9eXVxbWllYV1ZVVFNSUVBPTk1MS0pJSEdGRURDQkFAPz49PDs6OTg3NjU0MzIxMC8uLSwrKikoJyYlJCMiISAfHh0cGxoZGBcWFRQTEhEQDw4NDAsKCQgHBgUEAwIBAAAh+QQBAAABACwAAAAAMAAwAAACQoSPqcvtD6OctNqLs968+w+G4kiW5omm6spqQZu88CHPQD3jsN7yrN+zIYA/Ic1oIK6UKibyCY1Kp9Sq9YrNarehAgA7',
						fs: 'data:image/gif;base64,R0lGODlhMAAwAIABAP///wAAACH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjAxODAxMTc0MDcyMDY4MTFBRDU3RTExMEVEMjMzODQ2IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjVDQUI3RkEwMzhDMTExRTI5QkYwQTAzMDhDRDUwMDhGIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjVDQUI3RjlGMzhDMTExRTI5QkYwQTAzMDhDRDUwMDhGIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzUgTWFjaW50b3NoIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MDI4MDExNzQwNzIwNjgxMUFENTdFMTEwRUQyMzM4NDYiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MDE4MDExNzQwNzIwNjgxMUFENTdFMTEwRUQyMzM4NDYiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4B//79/Pv6+fj39vX08/Lx8O/u7ezr6uno5+bl5OPi4eDf3t3c29rZ2NfW1dTT0tHQz87NzMvKycjHxsXEw8LBwL++vby7urm4t7a1tLOysbCvrq2sq6qpqKempaSjoqGgn56dnJuamZiXlpWUk5KRkI+OjYyLiomIh4aFhIOCgYB/fn18e3p5eHd2dXRzcnFwb25tbGtqaWhnZmVkY2JhYF9eXVxbWllYV1ZVVFNSUVBPTk1MS0pJSEdGRURDQkFAPz49PDs6OTg3NjU0MzIxMC8uLSwrKikoJyYlJCMiISAfHh0cGxoZGBcWFRQTEhEQDw4NDAsKCQgHBgUEAwIBAAAh+QQBAAABACwAAAAAMAAwAAACWoSPqcvtD6OctNqLs968+w+G4kiW5omm6goErvu8sBdcNW1/d7VzuwyUHXq6YPBkPJqSQCTz5XwSRdJZ6Fcd6nI4yzTzhYRtQkeThU6r1+y2+w2Py+f0uj1TAAA7',
						ns: 'data:image/gif;base64,R0lGODlhMAAwAIABAP///wAAACH/C1hNUCBEYXRhWE1QPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS4wLWMwNjAgNjEuMTM0Nzc3LCAyMDEwLzAyLzEyLTE3OjMyOjAwICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIgeG1wTU06T3JpZ2luYWxEb2N1bWVudElEPSJ4bXAuZGlkOjAxODAxMTc0MDcyMDY4MTFBRDU3RTExMEVEMjMzODQ2IiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjdCNjgwOUZGM0Q4NzExRTI5RTIzREZENTNFODkxQkIwIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjdCNjgwOUZFM0Q4NzExRTI5RTIzREZENTNFODkxQkIwIiB4bXA6Q3JlYXRvclRvb2w9IkFkb2JlIFBob3Rvc2hvcCBDUzUgTWFjaW50b3NoIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MDE4MDExNzQwNzIwNjgxMTk2QTZCRDJCOEUyRDE4Q0MiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MDE4MDExNzQwNzIwNjgxMUFENTdFMTEwRUQyMzM4NDYiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4B//79/Pv6+fj39vX08/Lx8O/u7ezr6uno5+bl5OPi4eDf3t3c29rZ2NfW1dTT0tHQz87NzMvKycjHxsXEw8LBwL++vby7urm4t7a1tLOysbCvrq2sq6qpqKempaSjoqGgn56dnJuamZiXlpWUk5KRkI+OjYyLiomIh4aFhIOCgYB/fn18e3p5eHd2dXRzcnFwb25tbGtqaWhnZmVkY2JhYF9eXVxbWllYV1ZVVFNSUVBPTk1MS0pJSEdGRURDQkFAPz49PDs6OTg3NjU0MzIxMC8uLSwrKikoJyYlJCMiISAfHh0cGxoZGBcWFRQTEhEQDw4NDAsKCQgHBgUEAwIBAAAh+QQBAAABACwAAAAAMAAwAAACc4SPqcvtD6OctNqLs968+w+G4kiW5ommYMC27gu7G6vEdHJn+WEHta+59WyG3UU4hBWBOmBSCTBakM/WclZNYrO9LTfm/b6wS+416Pyem+XsGkN1R5lwenuMs0/13XxYbKUiOEhYaHiImKi4yNjo+Ah5UAAAOw==',
						background: '#000',
						hover: '#000'
					}
				}
			},
			scheme = schemes[options.koken_pulse_cosmic_style],
			title = $('<span/>')
						.css({
							display: 'block',
							fontWeight: 'bold',
							color: scheme.titleText,
							whiteSpace: 'nowrap',
							overflow: 'hidden',
							oTextOverflow: 'ellipsis',
							textOverflow: 'ellipsis',
							boxSizing: 'border-box'
						}),
			caption = title.clone().css({
				fontWeight: 'normal',
				color: scheme.text,
				marginTop: 4
			}),
			next = $('<img/>')
							.attr({
								width: 48,
								height: 48,
								src: scheme.buttons.next
							})
							.css({
								float: 'left',
								cursor: 'pointer',
								borderLeftWidth: 1,
								borderLeftStyle: 'solid',
								borderColor: scheme.borderColor,
								backgroundColor: scheme.buttons.background
							}),
			fs = next.clone().attr('src', scheme.buttons.fs),
			prev = next.clone().attr('src', scheme.buttons.prev);

		if (options.koken_pulse_cosmic_hover === false) {
			options.koken_pulse_cosmic_hover = scheme.buttons.hover;
		}

		if (!Pulse.fullScreenApi.supportsFullScreen) {
			options.koken_pulse_cosmic_fullscreen = false;
		}

		this.on('ready', function(e) {

			var multiplier = options.koken_pulse_cosmic_fullscreen ? 3 : 2,
				buttonWidth = 48 * multiplier,
				wrap = $('<div/>')
							.css({
								zIndex: 11,
								width: '100%',
								height: 48,
								backgroundColor: scheme.background,
								fontSize: 11,
								color: scheme.text,
								fontFamily: '"Helvetica Neue",Helvetica,Arial,sans-serif',
								padding: 0,
								margin: 0
							}),
				buttonsWrap = $('<div/>')
								.css({
									width: buttonWidth + multiplier,
									height: 48,
									float: 'right'
								});
				captionWrap = $('<div/>')
								.css({
									width: this.width() - buttonWidth - multiplier,
									lineHeight: "1.2",
									paddingTop: 10,
									paddingRight: 15,
									paddingBottom: 10,
									paddingLeft: 13,
									boxSizing: 'border-box'
								}),
				hover = function(e) {
					$(this).css('background-color', e.type === 'mousemove' ? options.koken_pulse_cosmic_hover : scheme.buttons.background);
				};

				next.on('mousemove mouseout', function(e) {
					if (nextActive) {
						$(this).css('background-color', e.type === 'mousemove' ? options.koken_pulse_cosmic_hover : scheme.buttons.background);
					}
				});

				prev.on('mousemove mouseout', function(e) {
					if (prevActive) {
						$(this).css('background-color', e.type === 'mousemove' ? options.koken_pulse_cosmic_hover : scheme.buttons.background);
					}
				});

				fs.on('mousemove mouseout', function(e) {
					$(this).css('background-color', e.type === 'mousemove' ? options.koken_pulse_cosmic_hover : scheme.buttons.background);
				});

				next.on('click', function() {
					if (nextActive) {
						self.next();
					}
				});

				prev.on('click', function() {
					if (prevActive) {
						self.previous();
					}
				});

				fs.on('click', function() {
					self.toggleFullscreen();
				});

				captionWrap.append(title);
				captionWrap.append(caption);

				if (options.koken_pulse_cosmic_controls) {
					if (options.koken_pulse_cosmic_fullscreen) {
						buttonsWrap.append(fs);
					}
					buttonsWrap.append(prev);
					buttonsWrap.append(next);
					buttonsWrap.appendTo(wrap);
				}
				captionWrap.appendTo(wrap);

				if (options.koken_pulse_cosmic_position === 'bottom') {
					this.append(wrap);
				} else {
					this.prepend(wrap);
				}
		});

		this.on('fullscreen', function(isFull) {
			if (isFull) {
				fs.attr('src', scheme.buttons.ns);
			} else {
				fs.attr('src', scheme.buttons.fs);
			}
		});

		this.on('itemnext', function(e) {
			if (!self.options.loop) {
				prevActive = !e.data.is_first;
				nextActive = !e.data.is_last;

				next.css({
					backgroundColor: nextActive ? scheme.buttons.background : scheme.buttonInactive
				});

				prev.css({
					backgroundColor: prevActive ? scheme.buttons.background : scheme.buttonInactive
				});
			}
			title.text((e.data.title || e.data.filename) + ' (' + e.data.position + ' of ' + e.data.total + ')');
			caption.text(e.data.caption);
			title.css('margin-top', e.data.caption.length ? 0 : 7);
		});
	};

})(Pulse);