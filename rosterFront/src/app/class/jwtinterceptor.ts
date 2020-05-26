import { Injectable } from '@angular/core';
import { HttpRequest, HttpHandler, HttpEvent, HttpInterceptor } from '@angular/common/http';
import { Observable } from 'rxjs';
import {RosterService} from "../service/roster.service";


@Injectable()
export class JwtInterceptor implements HttpInterceptor {
    constructor(private authService: RosterService) {}

    intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
        // add authorization header with jwt token if available
        const tokenData = this.authService.tokenData;
        if (tokenData && tokenData.token) {
            request = request.clone({
                setHeaders: {
                    Authorization: `Bearer ${tokenData.token}`
                }
            });
        }

        return next.handle(request);
    }
}
