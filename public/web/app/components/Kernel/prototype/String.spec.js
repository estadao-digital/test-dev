/**
 * @author  Hallison Boaventura <hallison.boaventura@aker.com.br>
 * @license www.aker.com.br Proprietary
 */
describe('String prototype', function() {
    it('pad left', function() {
        var actual = '9'.pad('0000000', 'left'),
            expected = '0000009';

        expect(actual).toEqual(expected);
    });

    it('pad right', function() {
        var actual = '8888'.pad('000000', 'right'),
            expected = '888800';

        expect(actual).toEqual(expected);
    });

    it('pad without parameters', function() {
        expect(function () {
            '33'.pad();
        })
        .toThrow(
            new Error('String::pad: typeof parameter pad must be string')
        );
    });
});
