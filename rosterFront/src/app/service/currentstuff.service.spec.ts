import { TestBed } from '@angular/core/testing';

import { CurrentstuffService } from './currentstuff.service';

describe('CurrentstuffService', () => {
  let service: CurrentstuffService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(CurrentstuffService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
