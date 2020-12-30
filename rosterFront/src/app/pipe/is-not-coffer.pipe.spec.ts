import { IsNotCofferPipe } from './is-not-coffer.pipe';

describe('IsNotCofferPipe', () => {
  it('create an instance', () => {
    const pipe = new IsNotCofferPipe();
    expect(pipe).toBeTruthy();
  });
});
