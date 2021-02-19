<?php
class ZoomApiHelper
{

    public static function createZoomMeeting($meetingConfig = [])
    {
        $jwtToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6Ik9xYjRoNnVHVDlHM09yZm9DcFZpQ0EiLCJleHAiOjE2MTQzMjIwNTcsImlhdCI6MTYxMzcxNzI2MX0.hl6ORgGYvzg-1RG15ND3QbTYbTppShQI1n10y0uVqSg';
        // $jwtToken = 'eyJhbGciOiJIUzUxMiIsInYiOiIyLjAiLCJraWQiOiJkMTJjNGNkZC0yNzRkLTQyYzYtOTE1Yi04NzQ4OGRjZDEyODIifQ.eyJ2ZXIiOjcsImF1aWQiOiJmMDcxYTJlNzE4NjY5NjgxNjEwYTE0MjNiN2EzODA4NSIsImNvZGUiOiJlblB5TnlXUmZGX1BSb2xZZ1BJVC1xeVpvRG1vYXd4dWciLCJpc3MiOiJ6bTpjaWQ6M1FDZ05FZ3JTTnlmQ25MTE93ZHE4ZyIsImdubyI6MCwidHlwZSI6MCwidGlkIjowLCJhdWQiOiJodHRwczovL29hdXRoLnpvb20udXMiLCJ1aWQiOiJQUm9sWWdQSVQtcXlab0Rtb2F3eHVnIiwibmJmIjoxNjEzNzI3OTUyLCJleHAiOjE2MTM3MzE1NTIsImlhdCI6MTYxMzcyNzk1MiwiYWlkIjoidjkxVEVsTm5Ram1BUi1CY00tWmJXZyIsImp0aSI6IjY1YWE3NmUxLTJmYTUtNDEzZi05ZTI1LWY0ODI4MTEzNjFiZiJ9.wiMCnUexFExqrNLWAPhbYVc-FnkiMSn_f5ZAjPR4pBV7TWbUOVtjCA37LMKoQrSQ6RdqsRkvM81K4BOghr6DPA';

        $requestBody = [
            'topic'            => $meetingConfig['topic']         ?? 'PHP General Talk',
            'type'            => $meetingConfig['type']         ?? 2,
            'start_time'    => $meetingConfig['start_time']    ?? date('Y-m-dTh:i:00') . 'Z',
            'duration'        => $meetingConfig['duration']     ?? 30,
            'password'        => $meetingConfig['password']     ?? mt_rand(),
            'timezone'        => 'Africa/Cairo',
            'agenda'        => 'PHP Session',
            'settings'        => [
                'host_video'            => false,
                'participant_video'        => true,
                'cn_meeting'            => false,
                'in_meeting'            => false,
                'join_before_host'        => true,
                'mute_upon_entry'        => true,
                'watermark'                => false,
                'use_pmi'                => false,
                'approval_type'            => 1,
                'registration_type'        => 1,
                'audio'                    => 'voip',
                'auto_recording'        => 'none',
                'waiting_room'            => false
            ]
        ];

        $zoomUserId = 'PRolYgPIT-qyZoDmoawxug';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // Skip SSL Verification
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.zoom.us/v2/users/" . $zoomUserId . "/meetings",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($requestBody),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $jwtToken,
                "Content-Type: application/json",
                "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        return $response;
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return [
                'success'     => false,
                'msg'         => 'cURL Error #:' . $err,
                'response'     => ''
            ];
        } else {
            return [
                'success'     => true,
                'msg'         => 'success',
                'response'     => json_decode($response)
            ];
        }
    }
}
echo ZoomApiHelper::createZoomMeeting();